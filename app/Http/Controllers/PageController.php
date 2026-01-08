<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\ChatRoom;
use App\Models\Event;
use App\Models\Poem;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PageController extends Controller
{
    /**
     * Display the home page.
     */
    public function home(): View
    {
        $user = Auth::user();
        $trendingBooks = Book::where('approved', true)->latest()->take(4)->get();
        $upcomingEvents = Event::where('date', '>', now())->orderBy('date', 'asc')->take(3)->get();
        $liveChatrooms = ChatRoom::with('members')->latest()->take(2)->get();
        $trendingPoems = Poem::latest()->take(5)->get();

        return view('index', compact('user', 'trendingBooks', 'upcomingEvents', 'liveChatrooms', 'trendingPoems'));
    }

    /**
     * Display the refund and cancellation policies page.
     */
    public function refundPolicies(): View
    {
        return view('refund-cancellation-policies');
    }
}
