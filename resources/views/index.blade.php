@extends('layouts.app')

@section('title', 'Welcome - VerseFountain')

@php
    $user = auth()->user();
    $trendingBooks = \App\Models\Book::where('approved', true)->latest()->take(4)->get();
    $upcomingEvents = \App\Models\Event::where('date', '>', now())->orderBy('date', 'asc')->take(3)->get();
    $liveChatrooms = \App\Models\ChatRoom::with('members')->latest()->take(2)->get();
    $trendingPoems = \App\Models\Poem::latest()->take(5)->get();
@endphp

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-8xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content Area -->
        <main class="lg:col-span-2 space-y-6">
            <!-- Page Header -->
            <div class="mb-6">
                <h1 class="text-3xl sm:text-4xl font-semibold text-gray-900 mb-2">Welcome to VerseFountain</h1>
                <p class="text-base text-gray-600 leading-relaxed max-w-2xl">
                    @auth
                        Good {{ date('H') < 12 ? 'morning' : (date('H') < 18 ? 'afternoon' : 'evening') }}, {{ $user->first_name ?? $user->username ?? 'there' }}. Here's what's happening in your literary world today.
                    @else
                        Discover a world of poetry, books, and academic resources. Connect with a community of readers and writers.
                    @endauth
                </p>
            </div>

            <!-- Book of the Day -->
            <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                <div class="flex flex-col md:flex-row">
                    <div class="md:w-1/3 h-64 bg-gradient-to-br from-amber-900 to-amber-700 flex items-center justify-center">
                        <div class="text-center text-white p-6">
                            <i class="bx bx-book-open text-6xl mb-4 opacity-50"></i>
                        </div>
                    </div>
                    <div class="md:w-2/3 p-6">
                        <span class="inline-block px-3 py-1 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full mb-3">BOOK OF THE DAY</span>
                        <h2 class="text-2xl font-semibold text-gray-900 mb-2">The Hill We Climb</h2>
                        <p class="text-sm text-gray-600 mb-4">An inspiring call for unity and hope by Amanda Gorman. Dive into this lyrical masterpiece that captured hearts worldwide.</p>
                        <div class="flex gap-3">
                            <a href="/books" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                Read Now
                            </a>
                            <a href="/books" class="px-4 py-2 bg-white border border-blue-600 text-blue-600 text-sm font-medium rounded-lg hover:bg-blue-50 transition-colors flex items-center">
                                <i class="bx bx-book mr-2"></i>
                                Library
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Currently Reading (for authenticated users) -->
            @auth
            <div class="bg-white rounded-lg shadow-sm p-4">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-20 bg-gray-200 rounded flex-shrink-0 flex items-center justify-center">
                        <i class="bx bx-book text-2xl text-gray-400"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-base font-semibold text-gray-900">The Waste Land</h3>
                        <p class="text-sm text-gray-600">T.S. Eliot</p>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-1">
                            <span class="text-xs text-gray-600">Progress</span>
                            <span class="text-xs font-medium text-gray-900">45%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: 45%"></div>
                        </div>
                    </div>
                    <a href="/books" class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                        <i class="bx bx-play text-xl"></i>
                    </a>
                </div>
            </div>
            @else
            <!-- Call to Action for Guests -->
            <div class="bg-blue-500 rounded-lg p-6 text-center">
                <h2 class="text-2xl font-semibold text-white mb-2">Join Our Community</h2>
                <p class="text-base text-white/90 mb-6 max-w-2xl mx-auto">Connect with fellow poetry enthusiasts, discover new authors, and participate in literary events.</p>
                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('register') }}" class="bg-white text-blue-500 px-6 py-2.5 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">
                        Get Started
                    </a>
                    <a href="{{ route('login') }}" class="bg-white/20 text-white border border-white/30 px-6 py-2.5 text-sm font-medium rounded-lg hover:bg-white/30 transition-colors">
                        Sign In
                    </a>
                </div>
            </div>
            @endauth

            <!-- Recommended for You -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Recommended for You</h2>
                    <a href="/books" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All</a>
                </div>
                <div class="flex gap-4 overflow-x-auto pb-2">
                    @forelse($trendingBooks as $book)
                    <div class="flex-shrink-0 w-32">
                        <div class="w-32 h-48 bg-gray-200 rounded flex items-center justify-center mb-2">
                            @if($book->coverImage ?? false)
                                <img src="{{ $book->coverImage }}" alt="{{ $book->title }}" class="w-full h-full object-cover rounded">
                            @else
                                <i class="bx bx-book text-3xl text-gray-400"></i>
                            @endif
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900 truncate">{{ $book->title }}</h3>
                        <p class="text-xs text-gray-600 truncate">{{ $book->author }}</p>
                    </div>
                    @empty
                    <div class="flex-shrink-0 w-32">
                        <div class="w-32 h-48 bg-gray-100 rounded flex flex-col items-center justify-center mb-2 border-2 border-dashed border-gray-300">
                            <i class="bx bx-book text-3xl text-gray-400 mb-2"></i>
                            <span class="text-xs text-gray-600 text-center px-2">No books yet</span>
                        </div>
                    </div>
                    @endforelse
                    <div class="flex-shrink-0 w-32">
                        <div class="w-32 h-48 bg-gray-100 rounded flex flex-col items-center justify-center mb-2 border-2 border-dashed border-gray-300">
                            <i class="bx bx-plus text-3xl text-gray-400 mb-2"></i>
                            <span class="text-xs text-gray-600 text-center px-2">Discover</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trending Poetry -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Trending Poetry</h2>
                    <a href="/poetry" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All</a>
                </div>
                @if($trendingPoems->count() > 0)
                <div class="space-y-4">
                    @foreach($trendingPoems->take(3) as $poem)
                    <div class="flex items-start gap-3">
                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="bx bx-quote-left text-blue-600"></i>
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <a href="{{ route('poetry.show', $poem) }}" class="text-sm font-medium text-gray-900 hover:text-blue-600">{{ $poem->title }}</a>
                                <span class="text-xs text-gray-500">{{ $poem->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-gray-700 italic line-clamp-2">{{ Str::limit($poem->content ?? 'No content', 100) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <i class="bx bx-file text-4xl text-gray-300 mb-2"></i>
                    <p class="text-sm text-gray-500">No poetry available yet</p>
                </div>
                @endif
            </div>

            <!-- Creator Updates -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Creator Updates</h2>
                    <a href="/poetry" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All</a>
                </div>
                <div class="flex items-start gap-3">
                    <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                        <span class="text-white text-sm font-medium">SK</span>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-sm font-medium text-gray-900">Sarah Kay</span>
                            <span class="text-xs text-gray-500">15m ago</span>
                        </div>
                        <p class="text-sm text-gray-700">Just finished the draft for my new collection. Can't wait to share it with you all!</p>
                    </div>
                </div>
            </div>
        </main>

        <!-- Right Sidebar -->
        <aside class="space-y-6">
            <!-- Reading Challenge -->
            @auth
            <div class="bg-white rounded-lg shadow-sm p-6 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 opacity-10">
                    <i class="bx bx-trophy text-8xl text-yellow-500"></i>
                </div>
                <div class="relative">
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">Reading Challenge</h2>
                    <p class="text-sm text-gray-600 mb-4">You're on track! Keep it up.</p>
                    <div class="flex items-center justify-center mb-4">
                        <div class="relative w-32 h-32">
                            <svg class="transform -rotate-90 w-32 h-32">
                                <circle cx="64" cy="64" r="56" stroke="#e5e7eb" stroke-width="8" fill="none"></circle>
                                <circle cx="64" cy="64" r="56" stroke="#3b82f6" stroke-width="8" fill="none" 
                                        stroke-dasharray="352" stroke-dashoffset="211" stroke-linecap="round"></circle>
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-2xl font-semibold text-gray-900">12</span>
                                <span class="text-xs text-gray-600">of 20</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-sm text-gray-600 text-center mb-4">12 Books read</p>
                    <p class="text-xs text-gray-500 text-center mb-4">Goal: 20 books</p>
                    <a href="{{ route('dashboard') }}" class="block w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors text-center">
                        View Details
                    </a>
                </div>
            </div>
            @else
            <!-- Sign Up Prompt for Guests -->
            <div class="bg-white rounded-lg shadow-sm p-6 text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bx bx-user-plus text-2xl text-blue-600"></i>
                </div>
                <h2 class="text-lg font-semibold text-gray-900 mb-2">Join VerseFountain</h2>
                <p class="text-sm text-gray-600 mb-4">Start your reading journey today</p>
                <a href="{{ route('register') }}" class="block w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Sign Up Free
                </a>
            </div>
            @endauth

            <!-- Live Chatrooms -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Live Chatrooms</h2>
                    <span class="text-sm text-blue-600 font-medium">{{ $liveChatrooms->count() }} Active</span>
                </div>
                @if($liveChatrooms->count() > 0)
                <div class="space-y-4">
                    @foreach($liveChatrooms as $room)
                    <div class="border-b border-gray-200 pb-4 last:border-0 last:pb-0">
                        <div class="flex items-start justify-between mb-2">
                            <a href="{{ route('chatroom.show', $room) }}" class="text-sm font-semibold text-gray-900 hover:text-blue-600">{{ $room->name }}</a>
                            <span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs font-medium rounded-full">Live</span>
                        </div>
                        <p class="text-xs text-gray-600 mb-2">Discussing literary themes...</p>
                        <div class="flex items-center gap-2">
                            <div class="flex -space-x-2">
                                @for($i = 0; $i < min(3, $room->members->count()); $i++)
                                    <div class="w-6 h-6 bg-blue-500 rounded-full border-2 border-white"></div>
                                @endfor
                            </div>
                            <span class="text-xs text-gray-500">+{{ max(0, $room->members->count() - 3) }} others</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('chatrooms.index') }}" class="block w-full mt-4 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors text-center">
                    View All Rooms
                </a>
                @else
                <div class="text-center py-4">
                    <p class="text-sm text-gray-500">No active chatrooms</p>
                </div>
                @endif
            </div>

            <!-- Upcoming Events -->
            <div class="bg-white rounded-lg shadow-sm p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Upcoming Events</h2>
                @if($upcomingEvents->count() > 0)
                <div class="space-y-4">
                    @foreach($upcomingEvents as $event)
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-xs font-medium text-gray-900">{{ $event->date ? $event->date->format('M d') : 'TBA' }}</span>
                            <span class="text-xs text-gray-600">{{ $event->date ? $event->date->format('g:i A') : '' }}</span>
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900 mb-1">{{ $event->title }}</h3>
                        <p class="text-xs text-gray-600 mb-2">{{ $event->location ?? 'Online' }}</p>
                        <div class="flex items-center gap-2">
                            <i class="bx bx-user text-xs text-gray-400"></i>
                            <span class="text-xs text-gray-600">{{ rand(15, 50) }} attending</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('events.index') }}" class="block w-full mt-4 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors text-center">
                    View All Events
                </a>
                @else
                <div class="text-center py-4">
                    <p class="text-sm text-gray-500">No upcoming events</p>
                </div>
                @endif
            </div>
        </aside>
    </div>
</div>
@endsection
