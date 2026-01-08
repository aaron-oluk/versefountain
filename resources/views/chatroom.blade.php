@extends('layouts.app')

@section('title', $chatroom->name . ' - VerseFountain')
@section('pageTitle', $chatroom->name)

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Chatroom Header -->
    <div class="bg-white rounded-lg shadow-sm p-4 mb-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="{{ route('chatrooms.index') }}" class="text-gray-500 hover:text-gray-700">
                    <i class="bx bx-arrow-back text-xl"></i>
                </a>
                <div>
                    <h1 class="text-lg font-semibold text-gray-900">{{ $chatroom->name }}</h1>
                    @if($chatroom->description)
                        <p class="text-sm text-gray-500">{{ $chatroom->description }}</p>
                    @endif
                </div>
            </div>
            <div class="flex items-center gap-4">
                <span class="text-sm text-gray-500">
                    <i class="bx bx-user mr-1"></i>{{ $chatroom->members->count() }} members
                </span>
                @if($isMember)
                    <button onclick="leaveChatroom()" class="text-sm text-gray-500 hover:text-red-600">
                        Leave
                    </button>
                @endif
            </div>
        </div>
    </div>

    @if($isMember)
        <!-- Chat Interface -->
        <div class="bg-white rounded-lg shadow-sm overflow-hidden" id="chat-container">
            <!-- Messages Area -->
            <div id="messages-container" class="h-[500px] overflow-y-auto p-4 space-y-4">
                @forelse($messages as $message)
                    <div class="flex gap-3" data-message-id="{{ $message->id }}">
                        <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center flex-shrink-0">
                            <span class="text-xs font-medium text-white">
                                {{ strtoupper(substr($message->user->first_name ?? $message->user->username ?? 'U', 0, 1)) }}
                            </span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1">
                                <span class="text-sm font-medium text-gray-900">
                                    {{ $message->user->first_name ?? $message->user->username ?? 'Anonymous' }}
                                </span>
                                <span class="text-xs text-gray-400">
                                    {{ $message->created_at->diffForHumans() }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-700">{{ $message->message }}</p>
                        </div>
                    </div>
                @empty
                    <div id="empty-state" class="flex flex-col items-center justify-center h-full text-gray-400">
                        <i class="bx bx-message-dots text-4xl mb-2"></i>
                        <p class="text-sm">No messages yet. Start the conversation!</p>
                    </div>
                @endforelse
            </div>

            <!-- Message Input -->
            <div class="border-t border-gray-200 p-4">
                <form id="message-form" class="flex gap-3">
                    <input type="text" id="message-input" placeholder="Type your message..."
                        class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none text-sm"
                        maxlength="1000" autocomplete="off">
                    <button type="submit" id="send-button"
                        class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        <span id="send-text">Send</span>
                        <span id="sending-text" class="hidden">Sending...</span>
                    </button>
                </form>
            </div>
        </div>
    @else
        <!-- Join Prompt -->
        <div class="bg-white rounded-lg shadow-sm p-12 text-center">
            <div class="max-w-md mx-auto">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bx bx-message-dots text-2xl text-gray-400"></i>
                </div>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Join this chatroom</h3>
                <p class="text-gray-500 mb-6">You need to join this chatroom to participate in the conversation.</p>
                @auth
                    <button onclick="joinChatroom()"
                        class="px-6 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        Join Chatroom
                    </button>
                @else
                    <a href="{{ route('login') }}"
                        class="inline-block px-6 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        Login to Join
                    </a>
                @endauth
            </div>
        </div>
    @endif
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const roomId = {{ $chatroom->id }};
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
    const chatUrl = "{{ url('/chat/rooms') }}";

    @if($isMember)
    const messagesContainer = document.getElementById('messages-container');
    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('message-input');
    const sendButton = document.getElementById('send-button');
    const sendText = document.getElementById('send-text');
    const sendingText = document.getElementById('sending-text');
    const emptyState = document.getElementById('empty-state');

    // Scroll to bottom on load
    scrollToBottom();

    // Handle form submission
    messageForm.addEventListener('submit', async function(e) {
        e.preventDefault();

        const message = messageInput.value.trim();
        if (!message) return;

        // Update UI state
        sendText.classList.add('hidden');
        sendingText.classList.remove('hidden');
        sendButton.disabled = true;
        messageInput.disabled = true;

        try {
            const response = await fetch(`${chatUrl}/${roomId}/messages`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message })
            });

            if (response.ok) {
                const data = await response.json();
                addMessageToUI(data);
                messageInput.value = '';
            } else {
                const errorData = await response.json();
                alert(errorData.message || 'Failed to send message');
            }
        } catch (error) {
            console.error('Error sending message:', error);
            alert('Failed to send message. Please try again.');
        } finally {
            sendText.classList.remove('hidden');
            sendingText.classList.add('hidden');
            sendButton.disabled = false;
            messageInput.disabled = false;
            messageInput.focus();
        }
    });

    // Add message to UI
    function addMessageToUI(message) {
        // Remove empty state if present
        if (emptyState) {
            emptyState.remove();
        }

        const messageHtml = `
            <div class="flex gap-3" data-message-id="${message.id}">
                <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center flex-shrink-0">
                    <span class="text-xs font-medium text-white">
                        ${(message.username || 'U').charAt(0).toUpperCase()}
                    </span>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        <span class="text-sm font-medium text-gray-900">
                            ${message.username || 'Anonymous'}
                        </span>
                        <span class="text-xs text-gray-400">just now</span>
                    </div>
                    <p class="text-sm text-gray-700">${escapeHtml(message.message)}</p>
                </div>
            </div>
        `;

        messagesContainer.insertAdjacentHTML('beforeend', messageHtml);
        scrollToBottom();
    }

    function scrollToBottom() {
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    }

    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    // Real-time messaging with Laravel Echo (if available)
    if (typeof Echo !== 'undefined') {
        Echo.join(`chat.room.${roomId}`)
            .here((users) => {
                console.log('Users in room:', users.length);
            })
            .joining((user) => {
                console.log('User joined:', user.username);
            })
            .leaving((user) => {
                console.log('User left:', user.username);
            })
            .listen('ChatMessageSent', (e) => {
                // Only add if not from current user (we already added it locally)
                const existingMessage = document.querySelector(`[data-message-id="${e.id}"]`);
                if (!existingMessage) {
                    addMessageToUI(e);
                }
            });
    }
    @endif

    // Join chatroom
    window.joinChatroom = async function() {
        try {
            const response = await fetch(`${chatUrl}/${roomId}/join`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                window.location.reload();
            } else {
                const data = await response.json();
                alert(data.message || 'Failed to join chatroom');
            }
        } catch (error) {
            console.error('Error joining chatroom:', error);
            alert('An error occurred while joining the chatroom');
        }
    };

    // Leave chatroom
    window.leaveChatroom = async function() {
        if (!confirm('Are you sure you want to leave this chatroom?')) {
            return;
        }

        try {
            const response = await fetch(`${chatUrl}/${roomId}/leave`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json'
                }
            });

            if (response.ok) {
                window.location.href = "{{ route('chatrooms.index') }}";
            } else {
                alert('Failed to leave chatroom');
            }
        } catch (error) {
            console.error('Error leaving chatroom:', error);
            alert('An error occurred while leaving the chatroom');
        }
    };
});
</script>
@endsection
