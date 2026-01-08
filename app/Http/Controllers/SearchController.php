<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Poem;
use App\Models\User;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->get('q', '');

        $books = collect();
        $poems = collect();
        $creators = collect();

        if ($query) {
            $searchTerm = "%{$query}%";

            $books = Book::where('approved', true)
                ->where(function ($q) use ($searchTerm) {
                    $q->where('title', 'like', $searchTerm)
                        ->orWhere('author', 'like', $searchTerm)
                        ->orWhere('description', 'like', $searchTerm);
                })
                ->limit(10)
                ->get();

            $poems = Poem::with('author')
                ->where('approved', true)
                ->where(function ($q) use ($searchTerm) {
                    $q->where('title', 'like', $searchTerm)
                        ->orWhere('content', 'like', $searchTerm);
                })
                ->limit(10)
                ->get();

            $creators = User::withCount(['poems' => fn($q) => $q->where('approved', true), 'followers'])
                ->where(function ($q) use ($searchTerm) {
                    $q->where('username', 'like', $searchTerm)
                        ->orWhere('first_name', 'like', $searchTerm)
                        ->orWhere('last_name', 'like', $searchTerm);
                })
                ->limit(10)
                ->get();
        }

        if ($request->wantsJson()) {
            return response()->json([
                'query' => $query,
                'books' => $books,
                'poems' => $poems,
                'creators' => $creators,
            ]);
        }

        return view('search', compact('query', 'books', 'poems', 'creators'));
    }
}
