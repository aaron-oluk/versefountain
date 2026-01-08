<?php
// app/Http/Controllers/BookController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class BookController extends Controller
{
    /**
     * Retrieve a list of all approved books.
     * Returns JSON for API requests, Blade view for web requests.
     */
    public function index(Request $request)
    {
        $query = Book::where('approved', true);

        // Apply filters
        if ($request->has('genre') && $request->genre) {
            $request->validate(['genre' => 'string|max:255']);
            $query->where('genre', $request->genre);
        }
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('author', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhere('genre', 'like', '%' . $search . '%');
            });
        }

        // If API request (wants JSON), return JSON
        if ($request->wantsJson() || $request->expectsJson()) {
            // Cache books for 5 minutes to improve performance
            $cacheKey = 'books.all';
            if ($request->has('genre')) {
                $cacheKey .= '.genre.' . $request->genre;
            }
            if ($request->has('limit')) {
                $cacheKey .= '.limit.' . $request->limit;
            }
            if ($request->has('offset')) {
                $cacheKey .= '.offset.' . $request->offset;
            }

            $books = Cache::remember($cacheKey, 300, function () use ($query, $request) {
                $limit = $request->input('limit', 10);
                $offset = $request->input('offset', 0);

                return $query->select('id', 'title', 'author', 'description', 'coverImage', 'genre', 'approved', 'uploadedById', 'created_at')
                             ->with('uploadedBy:id,username')
                             ->offset($offset)
                             ->limit($limit)
                             ->get();
            });

            return response()->json($books);
        }

        // Otherwise, return Blade view for web requests
        $genre = $request->get('genre');
        $sort = $request->get('sort', 'latest');

        // Apply genre filter
        if ($genre && $genre !== 'all') {
            $query->where('genre', $genre);
        }

        // Apply sorting
        match ($sort) {
            'title' => $query->orderBy('title', 'asc'),
            'oldest' => $query->oldest(),
            default => $query->latest(),
        };

        $allBooks = $query->paginate(12)->withQueryString();
        $trendingBooks = Book::where('approved', true)->latest()->take(3)->get();
        $genres = Book::where('approved', true)->whereNotNull('genre')->distinct()->pluck('genre');

        return view('books', compact('allBooks', 'trendingBooks', 'genres', 'genre', 'sort'));
    }

    /**
     * Retrieve a single book by its ID (API).
     */
    public function show(Book $book)
    {
        // Eager load relationships
        $book->load('uploadedBy');
        return response()->json($book);
    }

    /**
     * Display the specified book (Blade view).
     */
    public function showWeb($identifier)
    {
        // Hardcoded books data (matching books.blade.php)
        $hardcodedBooks = [
            'great-gatsby' => [
                'title' => 'The Great Gatsby',
                'author' => 'F. Scott Fitzgerald',
                'genre' => 'Fiction',
                'description' => 'A classic American novel set in the Jazz Age, exploring themes of wealth, love, and the American Dream through the eyes of Nick Carraway and his mysterious neighbor Jay Gatsby.',
            ],
            'midnight-library' => [
                'title' => 'The Midnight Library',
                'author' => 'Matt Haig',
                'genre' => 'Fiction',
                'description' => 'A thought-provoking novel about a library between life and death where every book represents a different life you could have lived.',
            ],
        ];

        // Try to find by ID first
        $book = null;
        if (is_numeric($identifier)) {
            $book = Book::find($identifier);
        }

        // If not found by ID, check hardcoded books
        if (!$book && isset($hardcodedBooks[$identifier])) {
            $bookData = $hardcodedBooks[$identifier];
            $book = (object) [
                'id' => 0,
                'title' => $bookData['title'],
                'author' => $bookData['author'],
                'genre' => $bookData['genre'],
                'description' => $bookData['description'],
                'created_at' => now(),
            ];
        } else if (!$book) {
            // Try to find by title in database
            $title = str_replace('-', ' ', $identifier);
            $title = ucwords($title);
            $book = Book::where('title', 'like', '%' . $title . '%')->first();
        }

        // If still not found, create a basic mock
        if (!$book) {
            $book = (object) [
                'id' => 0,
                'title' => ucwords(str_replace('-', ' ', $identifier)),
                'author' => 'Unknown',
                'genre' => 'General',
                'description' => 'This book is not yet available in our database.',
                'created_at' => now(),
            ];
        }

        return view('books.show', compact('book'));
    }

    /**
     * Display book reading interface.
     */
    public function read(Book $book)
    {
        return view('books.read', ['book' => $book]);
    }

    /**
     * Upload a book cover image.
     */
    public function uploadCover(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $request->validate([
            'cover_image' => 'required|string', // Accept base64 image data
        ]);

        $coverImage = $request->input('cover_image');
        
        // If it's not a base64 string and a file was uploaded
        if ($request->hasFile('cover_image')) {
            $file = $request->file('cover_image');
            $coverImage = base64_encode(file_get_contents($file->getRealPath()));
        }

        // Return the base64 data
        return response()->json(['coverImage' => $coverImage]);
    }

    /**
     * Add a new book.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'coverImage' => 'nullable|string', // Accept base64 image data or URL
            'genre' => 'nullable|string|max:255',
        ]);

        $book = Book::create($validatedData + ['uploadedById' => $user->id, 'approved' => false]); // Default to false for admin approval

        // Clear cache to ensure fresh data
        Cache::flush(); // Clear all book caches

        return response()->json($book, 201);
    }
}
