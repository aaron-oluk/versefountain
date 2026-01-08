<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatRoom;
use App\Models\ChatRoomInvitation;
use App\Models\ChatRoomJoinRequest;
use App\Models\User;
use App\Events\UserJoinedChatRoom;
use App\Events\UserLeftChatRoom;
use Illuminate\Support\Facades\Auth;

class ChatRoomController extends Controller
{
    /**
     * Display the chatrooms listing page.
     */
    public function list(Request $request)
    {
        $chatrooms = ChatRoom::withCount('members')->with('createdBy')->latest()->get();
        $userChatrooms = Auth::user()->chatRooms ?? collect();
        $pendingRequests = [];

        if (Auth::check()) {
            $pendingRequests = ChatRoomJoinRequest::where('user_id', Auth::id())
                ->where('status', 'pending')
                ->pluck('chat_room_id')
                ->toArray();
        }

        if ($request->get('filter') === 'my-rooms') {
            $chatrooms = $userChatrooms->load('createdBy')->loadCount('members');
        }

        return view('chatrooms.index', compact('chatrooms', 'userChatrooms', 'pendingRequests'));
    }

    public function index(Request $request)
    {
        $query = ChatRoom::query()->withCount('members');

        if ($request->has('is_private')) {
            $request->validate(['is_private' => 'boolean']);
            $query->where('is_private', $request->boolean('is_private'));
        } else {
            if (!Auth::check()) {
                $query->where('is_private', false);
            }
        }

        if ($request->boolean('joined') && Auth::check()) {
            $user = Auth::user();
            // Use whereIn with subquery for better performance than whereHas
            $query->whereIn('chat_rooms.id', function ($subquery) use ($user) {
                $subquery->select('room_id')
                         ->from('user_chat_rooms')
                         ->where('user_id', $user->id);
            });
        }

        $chatRooms = $query->get();

        return response()->json($chatRooms);
    }

    public function show(ChatRoom $chatroom)
    {
        // Load relationships
        $chatroom->load('members', 'messages.user');

        if ($chatroom->is_private) {
            $user = Auth::user();
            // Use eager loaded relationship instead of separate query
            if (!$user || !$chatroom->members->contains('id', $user->id)) {
                abort(403, 'Forbidden. You are not a member of this private chat room.');
            }
        }

        $isMember = Auth::check() && $chatroom->members->contains('id', Auth::id());
        $messages = $chatroom->messages()->with('user')->latest()->take(50)->get()->reverse();

        return view('chatroom', compact('chatroom', 'isMember', 'messages'));
    }

    public function apiShow(ChatRoom $room)
    {
        // Load relationships for API response
        $room->load('members');
        
        if ($room->is_private) {
            $user = Auth::user();
            // Use eager loaded relationship instead of separate query
            if (!$user || !$room->members->contains('id', $user->id)) {
                return response()->json(['message' => 'Forbidden. You are not a member of this private chat room.'], 403);
            }
        }
        return response()->json($room);
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_private' => 'boolean',
        ]);

        $chatRoom = ChatRoom::create([
            'name' => $validatedData['name'],
            'description' => $validatedData['description'] ?? null,
            'is_private' => $validatedData['is_private'] ?? false,
            'created_by_id' => $user->id,
        ]);

        $chatRoom->members()->attach($user->id, ['joinedAt' => now()]);

        if ($request->wantsJson() || $request->expectsJson()) {
            return response()->json($chatRoom, 201);
        }

        return redirect()
            ->route('chatroom.show', $chatRoom)
            ->with('success', 'Chatroom created successfully.');
    }

    public function userChatRooms(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $chatRooms = $user->chatRooms()->withCount('members')->get();

        return response()->json($chatRooms);
    }

    public function joinRoom(ChatRoom $room)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        if ($room->is_private) {
            if ($room->created_by_id !== $user->id && $user->role !== 'admin') {
                return response()->json(['message' => 'Forbidden. You cannot join this private chat room without an invitation or admin privileges.'], 403);
            }
        }

        // Load members once to check membership
        $room->load('members');
        if ($room->members->contains('id', $user->id)) {
            return response()->json(['message' => 'Already a member of this chat room.'], 200);
        }

        $room->members()->attach($user->id, ['joinedAt' => now()]);

        // Broadcast the join event via WebSockets
        event(new UserJoinedChatRoom($user, $room));

        return response()->json(['message' => 'Successfully joined chat room.'], 200);
    }

    public function leaveRoom(ChatRoom $room)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        $detached = $room->members()->detach($user->id);

        if ($detached) {
            // Broadcast the leave event via WebSockets
            event(new UserLeftChatRoom($user, $room));
            return response()->json(null, 204);
        }

        return response()->json(['message' => 'You are not a member of this chat room.'], 404);
    }

    public function getMembershipStatus(ChatRoom $room)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        // Load members once and check in memory
        $room->load('members');
        $isMember = $room->members->contains('id', $user->id);
        return response()->json(['isMember' => $isMember]);
    }

    public function requestJoin(Request $request, ChatRoom $room)
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        if (!$room->is_private) {
            return response()->json(['message' => 'This chatroom is public. You can join directly.'], 400);
        }

        // Check if already a member
        if ($room->members()->where('user_id', $user->id)->exists()) {
            return response()->json(['message' => 'You are already a member of this chatroom.'], 400);
        }

        // Check if there's already a pending request
        $existingRequest = ChatRoomJoinRequest::where('user_id', $user->id)
            ->where('chat_room_id', $room->id)
            ->where('status', 'pending')
            ->first();

        if ($existingRequest) {
            return response()->json(['message' => 'You already have a pending request for this chatroom.'], 400);
        }

        $request->validate([
            'message' => 'nullable|string|max:500',
        ]);

        $joinRequest = ChatRoomJoinRequest::create([
            'user_id' => $user->id,
            'chat_room_id' => $room->id,
            'message' => $request->message,
        ]);

        return response()->json([
            'message' => 'Join request sent successfully.',
            'request' => $joinRequest->load('user'),
        ], 201);
    }

    public function approveJoinRequest(ChatRoomJoinRequest $joinRequest)
    {
        $user = Auth::user();
        $room = $joinRequest->chatRoom;

        // Check if user is the creator or admin
        if ($room->created_by_id !== $user->id && $user->role !== 'admin') {
            return response()->json(['message' => 'You do not have permission to approve requests.'], 403);
        }

        if ($joinRequest->status !== 'pending') {
            return response()->json(['message' => 'This request has already been reviewed.'], 400);
        }

        $joinRequest->approve($user->id);

        // Add user to chatroom
        $room->members()->attach($joinRequest->user_id, ['joinedAt' => now()]);

        return response()->json([
            'message' => 'Join request approved successfully.',
            'request' => $joinRequest->fresh()->load(['user', 'reviewer']),
        ]);
    }

    public function rejectJoinRequest(ChatRoomJoinRequest $joinRequest)
    {
        $user = Auth::user();
        $room = $joinRequest->chatRoom;

        // Check if user is the creator or admin
        if ($room->created_by_id !== $user->id && $user->role !== 'admin') {
            return response()->json(['message' => 'You do not have permission to reject requests.'], 403);
        }

        if ($joinRequest->status !== 'pending') {
            return response()->json(['message' => 'This request has already been reviewed.'], 400);
        }

        $joinRequest->reject($user->id);

        return response()->json([
            'message' => 'Join request rejected.',
            'request' => $joinRequest->fresh()->load(['user', 'reviewer']),
        ]);
    }

    public function getPendingRequests(ChatRoom $room)
    {
        $user = Auth::user();

        // Check if user is the creator or admin
        if ($room->created_by_id !== $user->id && $user->role !== 'admin') {
            return response()->json(['message' => 'You do not have permission to view requests.'], 403);
        }

        $requests = ChatRoomJoinRequest::where('chat_room_id', $room->id)
            ->where('status', 'pending')
            ->with('user')
            ->latest()
            ->get();

        return response()->json(['requests' => $requests]);
    }

    /**
     * Show the user's chat rooms.
     */
    public function myRooms()
    {
        $user = Auth::user();
        $chatrooms = $user->chatRooms()->withCount('members')->with('createdBy')->latest()->get();
        $userChatrooms = $chatrooms;
        $pendingRequests = ChatRoomJoinRequest::where('user_id', $user->id)
            ->where('status', 'pending')
            ->pluck('chat_room_id')
            ->toArray();

        return view('chatrooms.index', compact('chatrooms', 'userChatrooms', 'pendingRequests'));
    }

    /**
     * Show the create chat room form.
     */
    public function create()
    {
        return view('chatrooms.create');
    }

    /**
     * Accept a chat room invitation.
     */
    public function acceptInvitation(ChatRoomInvitation $invitation)
    {
        $user = Auth::user();

        // Verify the invitation belongs to the authenticated user
        if ($invitation->user_id !== $user->id) {
            return redirect()->back()->with('error', 'Invalid invitation.');
        }

        // Update invitation status
        $invitation->update(['status' => 'accepted']);

        // Add user to the chat room
        $invitation->room->members()->attach($user->id);

        return redirect()->route('chatroom.show', $invitation->room)->with('success', 'Invitation accepted!');
    }

    /**
     * Decline a chat room invitation.
     */
    public function declineInvitation(ChatRoomInvitation $invitation)
    {
        $user = Auth::user();

        // Verify the invitation belongs to the authenticated user
        if ($invitation->user_id !== $user->id) {
            return redirect()->back()->with('error', 'Invalid invitation.');
        }

        // Update invitation status
        $invitation->update(['status' => 'declined']);

        return redirect()->back()->with('success', 'Invitation declined.');
    }
}