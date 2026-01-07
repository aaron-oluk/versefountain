<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Poem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

            // Search books using raw query with CONCAT for efficient multi-field search
            $books = Book::where('approved', true)
                ->whereRaw(
                    "CONCAT(COALESCE(title, ''), ' ', COALESCE(author, ''), ' ', COALESCE(description, '')) LIKE ?",
                    [$searchTerm]
                )
                ->limit(10)
                ->get();

            // Search poems with JOIN to get author info in single query
            $poems = Poem::select('poems.*', 'users.first_name', 'users.last_name', 'users.username')
                ->join('users', 'poems.author_id', '=', 'users.id')
                ->where('poems.approved', true)
                ->where(function ($q) use ($searchTerm) {
                    $q->where('poems.title', 'like', $searchTerm)
                        ->orWhere('poems.content', 'like', $searchTerm)
                        ->orWhere('users.username', 'like', $searchTerm)
                        ->orWhere('users.first_name', 'like', $searchTerm);
                })
                ->limit(10)
                ->get();

            // Search creators with counts using subqueries for better performance
            $creators = User::select('users.*')
                ->selectRaw('(SELECT COUNT(*) FROM poems WHERE poems.author_id = users.id AND poems.approved = 1) as poems_count')
                ->selectRaw('(SELECT COUNT(*) FROM poet_followers WHERE poet_followers.poet_id = users.id) as followers_count')
                ->whereRaw(
                    "CONCAT(COALESCE(username, ''), ' ', COALESCE(first_name, ''), ' ', COALESCE(last_name, '')) LIKE ?",
                    [$searchTerm]
                )
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
