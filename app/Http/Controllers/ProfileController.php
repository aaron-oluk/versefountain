<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Book;
use App\Models\ChatRoom;
use App\Models\Event;
use App\Models\Poem;
use App\Models\User;
use App\Models\Ticket;

class ProfileController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function dashboard(): View
    {
        $user = Auth::user();
        $upcomingEvents = Event::where('date', '>', now())->orderBy('date', 'asc')->take(3)->get();
        $recommendedBooks = Book::where('approved', true)->latest()->take(4)->get();
        $liveChatrooms = ChatRoom::withCount('members')->latest()->take(2)->get();
        $trendingPoems = Poem::where('approved', true)
            ->withCount('userInteractions')
            ->orderBy('user_interactions_count', 'desc')
            ->take(2)
            ->get();
        $featuredBook = Book::where('approved', true)->inRandomOrder()->first();
        $followedCreators = $user->following()->with('poems')->latest()->take(2)->get();
        $userTickets = Ticket::with('event')
            ->where('user_id', $user->id)
            ->whereIn('status', ['confirmed', 'pending'])
            ->whereHas('event', function ($query) {
                $query->where('date', '>', now());
            })
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $hour = now()->hour;
        $greeting = match (true) {
            $hour < 12 => 'Good morning',
            $hour < 17 => 'Good afternoon',
            default => 'Good evening',
        };

        return view('dashboard', compact(
            'user',
            'upcomingEvents',
            'recommendedBooks',
            'liveChatrooms',
            'trendingPoems',
            'featuredBook',
            'followedCreators',
            'greeting',
            'userTickets'
        ));
    }

    /**
     * Display the settings page.
     */
    public function settings(): View
    {
        return view('settings.index');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $request->user()->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('status', 'password-updated');
    }

    /**
     * Display the user's profile.
     */
    public function show(Request $request): View
    {
        $user = $request->user();
        $booksRead = 42; // TODO: implement actual tracking
        $following = $user->following()->count();
        $discussions = 85; // TODO: implement actual tracking
        $rank = 'Scribe Lvl. 5'; // TODO: implement actual ranking
        $currentlyReading = \App\Models\Book::where('approved', true)->first();
        $trendingBooks = \App\Models\Book::where('approved', true)->take(3)->get();
        $followedCreators = $user->following()->take(3)->get();

        return view('profile.show', compact(
            'user',
            'booksRead',
            'following',
            'discussions',
            'rank',
            'currentlyReading',
            'trendingBooks',
            'followedCreators'
        ));
    }

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
