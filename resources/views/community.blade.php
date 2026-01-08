@extends('layouts.app')

@section('title', 'Community - VerseFountain')
@section('pageTitle', 'Community')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <!-- Left Sidebar - Browse -->
            <div class="lg:col-span-1 space-y-6">
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Browse</h2>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mb-4">Filter by Topic</p>
                    
                    <nav class="space-y-2">
                        @auth
                        <a href="#" class="flex items-center justify-between px-3 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <div class="flex items-center gap-3">
                                <i class='bx bx-envelope text-xl'></i>
                                <span class="text-sm font-medium">Invites</span>
                            </div>
                            @if(count($pendingInvites) > 0)
                                <span class="px-2 py-1 bg-red-500 text-white text-xs font-bold rounded-full">{{ count($pendingInvites) }}</span>
                            @endif
                        </a>
                        @endauth
                        
                        <a href="{{ route('chatrooms.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <i class='bx bx-conversation text-xl'></i>
                            <span class="text-sm font-medium">All Discussions</span>
                        </a>
                        
                        @auth
                        <a href="{{ route('chatrooms.my') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <i class='bx bx-chat text-xl'></i>
                            <span class="text-sm font-medium">My Rooms</span>
                        </a>
                        @endauth
                        
                        <a href="#poetry-slams" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <i class='bx bx-microphone text-xl'></i>
                            <span class="text-sm font-medium">Poetry Slams</span>
                        </a>
                        
                        <a href="#book-clubs" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <i class='bx bx-book text-xl'></i>
                            <span class="text-sm font-medium">Book Clubs</span>
                        </a>
                        
                        <a href="#author-qa" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 text-gray-700 dark:text-gray-300">
                            <i class='bx bx-help-circle text-xl'></i>
                            <span class="text-sm font-medium">Author Q&A</span>
                        </a>
                    </nav>
                    
                    @auth
                    @if(count($myCommunities) > 0)
                        <div class="mt-6 pt-6 border-t border-gray-200 dark:border-gray-700">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-3">My Communities</h3>
                            <div class="space-y-2">
                                @foreach($myCommunities as $community)
                                    <a href="{{ route('chatroom.show', $community) }}" class="flex items-center gap-2 px-3 py-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 text-sm text-gray-700 dark:text-gray-300">
                                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                                        <span class="truncate">{{ $community->name }}</span>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @endauth
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                @auth
                @if(count($pendingInvites) > 0)
                <!-- Pending Invites -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center gap-2 mb-6">
                        <i class='bx bx-envelope text-2xl text-blue-600'></i>
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white">Pending Invites</h2>
                    </div>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($pendingInvites as $invite)
                            <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-700/50">
                                <div class="flex items-start gap-3 mb-3">
                                    <div class="w-10 h-10 bg-blue-500 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class='bx bx-lock-alt text-white text-xl'></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-gray-900 dark:text-white text-sm mb-1">{{ $invite->room->name }}</h3>
                                        <p class="text-xs text-gray-600 dark:text-gray-400">Invited by: {{ $invite->inviter->username }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-500 italic mt-1">"{{ $invite->room->description ?? 'Join us for great discussions!' }}"</p>
                                    </div>
                                </div>
                                <div class="flex gap-2">
                                    <form action="{{ route('chatroom.invitation.accept', $invite) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors">
                                            Accept
                                        </button>
                                    </form>
                                    <form action="{{ route('chatroom.invitation.decline', $invite) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" class="w-full px-4 py-2 bg-gray-200 dark:bg-gray-600 hover:bg-gray-300 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-300 text-sm font-semibold rounded-lg transition-colors">
                                            Decline
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif
                @endauth

                <!-- Explore Open Rooms -->
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Explore Open Rooms</h2>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Join public conversations with fellow readers and authors.</p>
                    
                    <!-- Filter Tabs -->
                    <div class="flex flex-wrap gap-2 mb-6">
                        <button class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                            Trending
                        </button>
                        <button class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-medium hover:bg-blue-700 transition-colors">
                            Newest
                        </button>
                        <button class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                            Creator Rooms
                        </button>
                        <button class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg text-sm font-medium hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                            Live Readings
                        </button>
                    </div>
                    
                    <!-- Room Cards -->
                    <div class="space-y-4">
                        @if($popularChatrooms->count() > 0)
                            @foreach($popularChatrooms as $chatroom)
                                <div class="flex flex-col sm:flex-row gap-4 p-4 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-blue-400 dark:hover:border-blue-500 hover:shadow-md transition-all">
                                    <!-- Room Image -->
                                    <div class="w-full sm:w-32 h-32 bg-gradient-to-br from-purple-500 to-blue-600 rounded-lg flex-shrink-0 overflow-hidden">
                                        @if(isset($chatroom->image))
                                            <img src="{{ $chatroom->image }}" alt="{{ $chatroom->name }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <i class='bx bx-conversation text-4xl text-white opacity-50'></i>
                                            </div>
                                        @endif
                                    </div>
                                    
                                    <!-- Room Info -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-start justify-between mb-2">
                                            <div class="flex-1">
                                                <div class="flex items-center gap-2 mb-2">
                                                    <span class="px-2 py-1 bg-purple-100 dark:bg-purple-900/40 text-purple-700 dark:text-purple-400 text-xs font-semibold rounded uppercase">
                                                        Book Club
                                                    </span>
                                                    <span class="px-2 py-1 bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-400 text-xs font-semibold rounded flex items-center gap-1">
                                                        <i class='bx bx-globe text-sm'></i> Open
                                                    </span>
                                                    <span class="text-xs text-green-600 dark:text-green-400 font-semibold flex items-center gap-1">
                                                        <i class='bx bx-radio-circle-marked text-sm'></i>
                                                        {{ $chatroom->members_count ?? 0 }} Online
                                                    </span>
                                                </div>
                                                <h3 class="font-bold text-gray-900 dark:text-white text-lg mb-2">{{ $chatroom->name }}</h3>
                                                <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2 mb-3">{{ $chatroom->description ?? 'Join the conversation and share your thoughts.' }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="flex items-center justify-between">
                                            <div class="flex items-center gap-1">
                                                <div class="flex -space-x-2">
                                                    @for($i = 0; $i < min(3, $chatroom->members_count ?? 0); $i++)
                                                        <div class="w-6 h-6 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full border-2 border-white dark:border-gray-800 flex items-center justify-center">
                                                            <span class="text-white text-xs font-semibold">{{ chr(65 + $i) }}</span>
                                                        </div>
                                                    @endfor
                                                </div>
                                            </div>
                                            <a href="{{ route('chatroom.show', $chatroom) }}" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg transition-colors">
                                                Join Room
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-12">
                                <i class="bx bx-message-dots text-5xl text-gray-300 dark:text-gray-600 mb-3"></i>
                                <p class="text-gray-500 dark:text-gray-400 mb-4">No open rooms available yet</p>
                                @auth
                                <a href="{{ route('chatrooms.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg transition-colors">
                                    <i class='bx bx-plus text-xl'></i>
                                    Create a Room
                                </a>
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Trending Books -->
                @if($trendingBooks->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Trending Books this Week</h3>
                    <div class="space-y-4">
                        @foreach($trendingBooks as $book)
                            <div class="flex gap-3">
                                <div class="w-16 h-20 bg-gradient-to-br from-amber-200 to-amber-400 rounded flex-shrink-0 overflow-hidden shadow-md">
                                    @if(isset($book->cover_image))
                                        <img src="{{ $book->cover_image }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <i class='bx bx-book text-2xl text-amber-700'></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h4 class="font-semibold text-sm text-gray-900 dark:text-white mb-1 line-clamp-2">{{ $book->title }}</h4>
                                    <p class="text-xs text-gray-600 dark:text-gray-400 mb-1">{{ $book->author }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-500">{{ rand(2, 8) }} active rooms</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Upcoming Events -->
                @if($upcomingEvents->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Upcoming Event</h3>
                    @php $firstEvent = $upcomingEvents->first(); @endphp
                    @if($firstEvent)
                        <div class="rounded-lg overflow-hidden mb-4">
                            <div class="h-40 bg-gradient-to-br from-orange-400 to-red-600 flex items-center justify-center">
                                <i class='bx bx-microphone text-6xl text-white opacity-50'></i>
                            </div>
                        </div>
                        <h4 class="font-bold text-gray-900 dark:text-white mb-2">{{ $firstEvent->title }}</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 line-clamp-2">{{ $firstEvent->description ?? 'Community reading and discussion of her most impactful poems.' }}</p>
                        <div class="flex items-center gap-2 text-sm text-gray-600 dark:text-gray-400 mb-4">
                            <i class='bx bx-calendar text-lg'></i>
                            <span>{{ $firstEvent->date ? $firstEvent->date->format('l, g:i A') : 'TBA' }}</span>
                        </div>
                        <button class="w-full px-4 py-3 bg-gray-900 dark:bg-white text-white dark:text-gray-900 font-semibold rounded-lg hover:bg-gray-800 dark:hover:bg-gray-100 transition-colors">
                            Set Reminder
                        </button>
                    @endif
                </div>
                @endif

                <!-- Active Creators -->
                @if($activeCreators->count() > 0)
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-bold text-gray-900 dark:text-white">Active Creators</h3>
                        <a href="{{ route('creators.index') }}" class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-700 font-semibold">View All →</a>
                    </div>
                    <div class="space-y-3">
                        @foreach($activeCreators->take(5) as $creator)
                            <a href="{{ route('profile.creator', $creator) }}" class="flex items-center gap-3 p-2 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-purple-600 rounded-full flex items-center justify-center flex-shrink-0 shadow-md">
                                    <span class="text-white text-sm font-semibold">{{ strtoupper(substr($creator->username, 0, 1)) }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <p class="font-semibold text-sm text-gray-900 dark:text-white truncate">{{ $creator->username }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ $creator->poems_count }} poem{{ $creator->poems_count !== 1 ? 's' : '' }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
