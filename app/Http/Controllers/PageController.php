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
        
        // Get recommended books - mix of latest and some variety using joins
        $trendingBooks = Book::select('books.*')
            ->join('users as uploaded_by', 'books.uploaded_by_id', '=', 'uploaded_by.id')
            ->where('books.approved', true)
            ->orderBy('books.created_at', 'desc')
            ->limit(8)
            ->get();
        
        // If we have fewer than 4 books, get more from different time periods
        if ($trendingBooks->count() < 4) {
            $excludedIds = $trendingBooks->pluck('id')->toArray();
            $additionalBooks = Book::select('books.*')
                ->join('users as uploaded_by', 'books.uploaded_by_id', '=', 'uploaded_by.id')
                ->where('books.approved', true)
                ->whereNotIn('books.id', $excludedIds)
                ->inRandomOrder()
                ->limit(4 - $trendingBooks->count())
                ->get();
            $trendingBooks = $trendingBooks->merge($additionalBooks);
        }
        
        // Get upcoming events using joins
        $upcomingEvents = Event::select('events.*')
            ->join('users as created_by', 'events.created_by_id', '=', 'created_by.id')
            ->where('events.date', '>', now())
            ->orderBy('events.date', 'asc')
            ->limit(3)
            ->get();
        
        // Get live chatrooms with member counts using joins
        $liveChatrooms = ChatRoom::select('chat_rooms.*')
            ->leftJoin('user_chat_rooms', 'chat_rooms.id', '=', 'user_chat_rooms.room_id')
            ->selectRaw('chat_rooms.*, COUNT(DISTINCT user_chat_rooms.user_id) as members_count')
            ->groupBy('chat_rooms.id')
            ->orderBy('chat_rooms.created_at', 'desc')
            ->limit(2)
            ->get();
        
        // Load members for the chatrooms
        $liveChatrooms->load('members');
        
        // Get trending poems with author data using joins
        $trendingPoems = Poem::select('poems.*')
            ->join('users as authors', 'poems.author_id', '=', 'authors.id')
            ->orderBy('poems.created_at', 'desc')
            ->limit(5)
            ->get();
        
        // Get followed creators using joins
        $followedCreators = collect();
        if ($user) {
            $followedCreators = User::select('users.*')
                ->join('poet_followers', 'users.id', '=', 'poet_followers.poet_id')
                ->where('poet_followers.follower_id', $user->id)
                ->with('poems')
                ->orderBy('poet_followers.created_at', 'desc')
                ->limit(3)
                ->get();
        }

        return view('index', compact('user', 'trendingBooks', 'upcomingEvents', 'liveChatrooms', 'trendingPoems', 'followedCreators'));
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
        
        // Get pending invitations for authenticated user using joins
        $pendingInvites = [];
        $userChatrooms = collect();
        if ($user) {
            $pendingInvites = ChatRoomInvitation::select('chat_room_invitations.*')
                ->join('chat_rooms', 'chat_room_invitations.room_id', '=', 'chat_rooms.id')
                ->leftJoin('users as inviters', 'chat_room_invitations.invited_by', '=', 'inviters.id')
                ->where('chat_room_invitations.user_id', $user->id)
                ->where('chat_room_invitations.type', 'invitation')
                ->where('chat_room_invitations.status', 'pending')
                ->orderBy('chat_room_invitations.created_at', 'desc')
                ->limit(4)
                ->get();
            
            // Load relationships
            $pendingInvites->load(['room', 'inviter']);
            
            // Get user's chatrooms using joins
            $userChatrooms = ChatRoom::select('chat_rooms.*')
                ->join('user_chat_rooms', 'chat_rooms.id', '=', 'user_chat_rooms.room_id')
                ->where('user_chat_rooms.user_id', $user->id)
                ->get();
        }
        
        // Get user's joined chat rooms with member counts using joins
        $myCommunities = [];
        if ($user) {
            $myCommunities = ChatRoom::select('chat_rooms.*')
                ->join('user_chat_rooms', 'chat_rooms.id', '=', 'user_chat_rooms.room_id')
                ->leftJoin('user_chat_rooms as member_counts', 'chat_rooms.id', '=', 'member_counts.room_id')
                ->selectRaw('chat_rooms.*, COUNT(DISTINCT member_counts.user_id) as members_count')
                ->where('user_chat_rooms.user_id', $user->id)
                ->groupBy('chat_rooms.id')
                ->limit(5)
                ->get();
        }
        
        // Get popular chatrooms with member counts using joins
        $popularChatrooms = ChatRoom::select('chat_rooms.*')
            ->leftJoin('user_chat_rooms', 'chat_rooms.id', '=', 'user_chat_rooms.room_id')
            ->selectRaw('chat_rooms.*, COUNT(DISTINCT user_chat_rooms.user_id) as members_count')
            ->groupBy('chat_rooms.id')
            ->orderBy('members_count', 'desc')
            ->limit(6)
            ->get();
        
        // Get recent poems with author data using joins
        $recentPoems = Poem::select('poems.*')
            ->join('users as authors', 'poems.author_id', '=', 'authors.id')
            ->orderBy('poems.created_at', 'desc')
            ->limit(8)
            ->get();
        
        // Load user relationship for poems
        $recentPoems->load('user');
        
        // Get upcoming events using joins
        $upcomingEvents = Event::select('events.*')
            ->join('users as created_by', 'events.created_by_id', '=', 'created_by.id')
            ->where('events.date', '>', now())
            ->orderBy('events.date', 'asc')
            ->limit(4)
            ->get();
        
        // Get active creators with poem counts using joins
        $activeCreators = User::select('users.*')
            ->join('poems', 'users.id', '=', 'poems.author_id')
            ->selectRaw('users.*, COUNT(poems.id) as poems_count')
            ->groupBy('users.id')
            ->havingRaw('COUNT(poems.id) > 0')
            ->orderBy('poems_count', 'desc')
            ->limit(6)
            ->get();
        
        // Get trending books using joins
        $trendingBooks = Book::select('books.*')
            ->join('users as uploaded_by', 'books.uploaded_by_id', '=', 'uploaded_by.id')
            ->where('books.approved', true)
            ->orderBy('books.created_at', 'desc')
            ->limit(3)
            ->get();

        return view('community', compact(
            'popularChatrooms', 
            'recentPoems', 
            'upcomingEvents', 
            'activeCreators',
            'pendingInvites',
            'myCommunities',
            'trendingBooks',
            'userChatrooms'
        ));
    }
}
