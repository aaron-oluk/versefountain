<?php

namespace App\Http\Controllers;

use App\Models\Poem;
use App\Models\User;
use App\Models\UserPoem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class PoemController extends Controller
{
    /**
     * Display a listing of poems (Blade view)
     */
    public function index()
    {
        $poems = Poem::with(['author', 'comments', 'userInteractions'])
            ->where('approved', true)
            ->latest()
            ->paginate(12);

        return view('poetry.index', compact('poems'));
    }

    /**
     * Show the form for creating a new poem (Blade view)
     */
    public function create()
    {
        return view('poetry.create');
    }

    /**
     * Show the poem submission page (Creator Studio).
     */
    public function submit()
    {
        return view('poetry.submit');
    }

    /**
     * Store a newly created poem
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:10000',
            'is_video' => 'boolean',
            'video_url' => 'nullable|url|required_if:is_video,1',
        ]);

        $poem = Poem::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'author_id' => Auth::id(),
            'is_video' => $validated['is_video'] ?? false,
            'video_url' => $validated['video_url'] ?? null,
            'approved' => true, // Auto-approve for now
        ]);

        return redirect()->route('poetry.show', $poem)
            ->with('success', 'Poem created successfully!');
    }

    /**
     * Display the specified poem (Blade view)
     */
    public function show(Poem $poem)
    {
        $poem->load(['author', 'comments.user', 'userInteractions']);

        $userRating = 0;
        $isLiked = false;

        if (Auth::check()) {
            $userInteraction = $poem->userInteractions->firstWhere('user_id', Auth::id());
            $isLiked = (bool) ($userInteraction->liked ?? false);
            $userRating = (int) ($userInteraction->rating ?? 0);
        }

        return view('poetry.show', compact('poem', 'isLiked', 'userRating'));
    }

    /**
     * Show the form for editing the specified poem (Blade view)
     */
    public function edit(Poem $poem)
    {
        // Check if user can edit this poem
        if (Auth::id() !== $poem->author_id) {
            abort(403, 'Unauthorized action.');
        }

        return view('poetry.edit', compact('poem'));
    }

    /**
     * Update the specified poem
     */
    public function update(Request $request, Poem $poem)
    {
        // Check if user can edit this poem
        if (Auth::id() !== $poem->author_id) {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string|max:10000',
            'is_video' => 'boolean',
            'video_url' => 'nullable|url|required_if:is_video,1',
        ]);

        $poem->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'is_video' => $validated['is_video'] ?? false,
            'video_url' => $validated['video_url'] ?? null,
        ]);

        return redirect()->route('poetry.show', $poem)
            ->with('success', 'Poem updated successfully!');
    }

    /**
     * Remove the specified poem
     */
    public function destroy(Poem $poem)
    {
        // Check if user can delete this poem
        if (Auth::id() !== $poem->author_id) {
            abort(403, 'Unauthorized action.');
        }

        $poem->delete();

        return redirect()->route('poetry.index')
            ->with('success', 'Poem deleted successfully!');
    }

    // API Methods (for JavaScript interactions)

    /**
     * Like or unlike a poem (API)
     */
    public function like(Poem $poem)
    {
        $user = Auth::user();
        $interaction = UserPoem::firstOrCreate(
            ['user_id' => $user->id, 'poem_id' => $poem->id],
            ['liked' => false]
        );

        $interaction->liked = !$interaction->liked;
        $interaction->save();

        $liked = $interaction->liked;

        $likesCount = UserPoem::where('poem_id', $poem->id)
            ->where('liked', true)
            ->count();

        return response()->json([
            'liked' => $liked,
            'likes_count' => $likesCount,
        ]);
    }

    /**
     * Unlike a poem (API)
     */
    public function unlike(Poem $poem)
    {
        $user = Auth::user();
        $interaction = UserPoem::firstOrCreate(
            ['user_id' => $user->id, 'poem_id' => $poem->id],
            ['liked' => false]
        );

        $interaction->liked = false;
        $interaction->save();

        $likesCount = UserPoem::where('poem_id', $poem->id)
            ->where('liked', true)
            ->count();

        return response()->json([
            'liked' => false,
            'likes_count' => $likesCount,
        ]);
    }

    /**
     * Rate a poem (API)
     */
    public function rate(Request $request, Poem $poem)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|between:1,5',
        ]);

        $user = Auth::user();
        
        // Update or create rating on the single interaction row
        $interaction = UserPoem::firstOrCreate(
            ['user_id' => $user->id, 'poem_id' => $poem->id],
            ['liked' => false]
        );

        $interaction->rating = $validated['rating'];
        $interaction->save();

        // Get rating stats in a single query using aggregation
        $ratingStats = UserPoem::where('poem_id', $poem->id)
            ->whereNotNull('rating')
            ->selectRaw('AVG(rating) as avg_rating, COUNT(*) as rating_count')
            ->first();

        return response()->json([
            'rating' => $validated['rating'],
            'average_rating' => round($ratingStats->avg_rating ?? 0, 1),
            'rating_count' => $ratingStats->rating_count ?? 0,
        ]);
    }

    /**
     * Approve a poem (Admin only)
     */
    public function approve(Poem $poem)
    {
        $poem->update(['approved' => true]);

        return response()->json(['message' => 'Poem approved successfully']);
    }

    /**
     * Get user's poems (API)
     */
    public function userPoems()
    {
        $poems = Poem::where('author_id', Auth::id())
            ->select('id', 'title', 'content', 'author_id', 'is_video', 'video_url', 'approved', 'created_at')
            ->with(['comments:id,poem_id,user_id,content,created_at', 'userInteractions'])
            ->latest()
            ->get();

        return response()->json($poems);
    }

    /**
     * Get like count for a poem (API)
     */
    public function getLikeCount(Poem $poem)
    {
        $likesCount = UserPoem::where('poem_id', $poem->id)
            ->where('liked', true)
            ->count();

        return response()->json([
            'likes_count' => $likesCount,
        ]);
    }

    /**
     * Get user status for a poem (API)
     */
    public function getUserStatus(Poem $poem)
    {
        $user = Auth::user();
        
        // Get all user interactions for this poem in a single query
        $interaction = UserPoem::where('user_id', $user->id)
            ->where('poem_id', $poem->id)
            ->first();
        
        // Get rating stats in a single query
        $ratingStats = UserPoem::where('poem_id', $poem->id)
            ->whereNotNull('rating')
            ->selectRaw('AVG(rating) as avg_rating, COUNT(*) as rating_count')
            ->first();

        return response()->json([
            'liked' => $interaction ? (bool)$interaction->liked : false,
            'rating' => $interaction ? ($interaction->rating ?? 0) : 0,
            'average_rating' => round($ratingStats->avg_rating ?? 0, 1),
            'rating_count' => $ratingStats->rating_count ?? 0,
        ]);
    }
}
