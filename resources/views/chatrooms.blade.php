@extends('layouts.app')

@section('title', 'Chatrooms - VerseFountain')

@php $pageTitle = 'Chatrooms'; @endphp

@section('content')
<div class="max-w-5xl mx-auto">
    <!-- Header with Create Button -->
    <div class="flex items-center justify-between mb-6">
        <div>
            <h1 class="text-xl font-bold text-gray-900 mb-1">Explore Chatrooms</h1>
            <p class="text-sm text-gray-500">Join conversations with fellow readers and writers.</p>
        </div>
        @auth
        <button onclick="openCreateRoomModal()" class="px-4 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2">
            <i class="bx bx-plus text-lg"></i>
            Create Room
        </button>
        @endauth
    </div>

    <!-- Filter Tabs -->
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('chatrooms.index') }}" class="px-4 py-2 text-sm font-medium rounded-lg {{ !request('filter') ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }} transition-colors">
            All Rooms
        </a>
        @auth
        <a href="{{ route('chatrooms.index', ['filter' => 'my-rooms']) }}" class="px-4 py-2 text-sm font-medium rounded-lg {{ request('filter') === 'my-rooms' ? 'bg-blue-600 text-white' : 'bg-white text-gray-600 border border-gray-200 hover:bg-gray-50' }} transition-colors">
            My Rooms
            @if($userChatrooms->count() > 0)
                <span class="ml-1 px-1.5 py-0.5 bg-white/20 rounded text-xs">{{ $userChatrooms->count() }}</span>
            @endif
        </a>
        @endauth
    </div>

    <!-- Search -->
    <div class="mb-6">
        <div class="relative">
            <i class="bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
            <input type="text" id="searchRooms" placeholder="Search chatrooms..."
                   class="w-full pl-10 pr-4 py-2.5 bg-white border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm">
        </div>
    </div>

    <!-- Room Cards -->
    <div class="space-y-4" id="roomsList">
        @forelse($chatrooms as $room)
        <div class="bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow room-card" data-name="{{ strtolower($room->name) }}">
            <div class="flex items-center gap-2 mb-2 flex-wrap">
                @if($room->is_private)
                    <span class="px-2 py-0.5 bg-purple-100 text-purple-700 text-[10px] font-semibold rounded-full uppercase">Private</span>
                @else
                    <span class="px-2 py-0.5 bg-green-100 text-green-700 text-[10px] font-semibold rounded-full uppercase">Public</span>
                @endif
                <span class="flex items-center gap-1 text-[10px] text-green-600">
                    <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                    {{ $room->members_count }} members
                </span>
            </div>
            <h3 class="text-base font-semibold text-gray-900 mb-1">{{ $room->name }}</h3>
            <p class="text-sm text-gray-500 mb-3 line-clamp-2">{{ $room->description ?? 'Join the conversation!' }}</p>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2 text-xs text-gray-500">
                    <span>Created by</span>
                    <a href="{{ route('profile.creator', $room->createdBy->id ?? 1) }}" class="font-medium text-gray-700 hover:text-blue-600">
                        {{ $room->createdBy->first_name ?? $room->createdBy->username ?? 'Unknown' }}
                    </a>
                </div>
                @php
                    $isMember = $userChatrooms->contains('id', $room->id);
                @endphp
                @if($isMember)
                    <a href="{{ route('chatroom.show', $room->id) }}" class="px-4 py-1.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        Enter Room
                    </a>
                @else
                    <button onclick="joinRoom({{ $room->id }}, this)" class="px-4 py-1.5 bg-white border border-gray-200 text-gray-600 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">
                        Join Room
                    </button>
                @endif
            </div>
        </div>
        @empty
        <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
            <i class="bx bx-message-square-dots text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No chatrooms yet</h3>
            <p class="text-gray-500 mb-4">Be the first to create a chatroom!</p>
            @auth
            <button onclick="openCreateRoomModal()" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                Create Room
            </button>
            @endauth
        </div>
        @endforelse
    </div>
</div>

<!-- Create Room Modal -->
<div id="createRoomModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Create New Chatroom</h3>
        <form id="createRoomForm">
            <div class="space-y-4">
                <div>
                    <label for="roomName" class="block text-sm font-medium text-gray-700 mb-1">Room Name</label>
                    <input type="text" id="roomName" name="name" required
                           class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                </div>
                <div>
                    <label for="roomDescription" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea id="roomDescription" name="description" rows="3"
                              class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500"></textarea>
                </div>
                <div class="flex items-center">
                    <input type="checkbox" id="isPrivate" name="is_private" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                    <label for="isPrivate" class="ml-2 text-sm text-gray-700">Make this room private</label>
                </div>
            </div>
            <div class="flex justify-end space-x-3 mt-6">
                <button type="button" onclick="closeCreateRoomModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    Create Room
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Search functionality
document.getElementById('searchRooms').addEventListener('input', function(e) {
    const search = e.target.value.toLowerCase();
    document.querySelectorAll('.room-card').forEach(card => {
        const name = card.dataset.name;
        card.style.display = name.includes(search) ? 'block' : 'none';
    });
});

// Create room modal
function openCreateRoomModal() {
    document.getElementById('createRoomModal').classList.remove('hidden');
}

function closeCreateRoomModal() {
    document.getElementById('createRoomModal').classList.add('hidden');
}

// Create room form
document.getElementById('createRoomForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const formData = {
        name: document.getElementById('roomName').value,
        description: document.getElementById('roomDescription').value,
        is_private: document.getElementById('isPrivate').checked
    };

    fetch('/api/chat/rooms', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify(formData)
    })
    .then(response => response.json())
    .then(data => {
        if (data.id) {
            window.location.href = `/chat/rooms/${data.id}`;
        } else {
            alert(data.message || 'Failed to create room');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to create room');
    });
});

// Join room
function joinRoom(roomId, button) {
    fetch(`/api/chat/rooms/${roomId}/join`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.message && data.message.includes('success')) {
            button.textContent = 'Enter Room';
            button.classList.remove('bg-white', 'border', 'border-gray-200', 'text-gray-600', 'hover:bg-gray-50');
            button.classList.add('bg-blue-600', 'text-white', 'hover:bg-blue-700');
            button.onclick = () => window.location.href = `/chat/rooms/${roomId}`;
        } else {
            alert(data.message || 'Failed to join room');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Failed to join room');
    });
}
</script>
@endsection
