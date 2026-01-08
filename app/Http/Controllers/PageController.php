<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\ChatRoom;
use App\Models\ChatRoomInvitation;
use App\Models\Event;
use App\Models\Poem;
use App\Models\User;
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

    /**
     * Display the community page.
     */
    public function community(): View
    {
        $user = Auth::user();
        
        // Get pending invitations for authenticated user
        $pendingInvites = [];
        if ($user) {
            $pendingInvites = ChatRoomInvitation::with(['room', 'inviter'])
                ->where('user_id', $user->id)
                ->where('type', 'invitation')
                ->where('status', 'pending')
                ->latest()
                ->take(4)
                ->get();
        }
        
        // Get user's joined chat rooms
        $myCommunities = [];
        if ($user) {
            $myCommunities = $user->chatRooms()
                ->withCount('members')
                ->take(5)
                ->get();
        }
        
        $popularChatrooms = ChatRoom::withCount('members')
            ->orderBy('members_count', 'desc')
            ->take(6)
            ->get();
        
        $recentPoems = Poem::with('user')
            ->latest()
            ->take(8)
            ->get();
        
        $upcomingEvents = Event::where('date', '>', now())
            ->orderBy('date', 'asc')
            ->take(4)
            ->get();
        
        $activeCreators = User::has('poems')
            ->withCount('poems')
            ->orderBy('poems_count', 'desc')
            ->take(6)
            ->get();
        
        $trendingBooks = Book::where('approved', true)
            ->latest()
            ->take(3)
            ->get();

        return view('community', compact(
            'popularChatrooms', 
            'recentPoems', 
            'upcomingEvents', 
            'activeCreators',
            'pendingInvites',
            'myCommunities',
            'trendingBooks'
        ));
    }
}
