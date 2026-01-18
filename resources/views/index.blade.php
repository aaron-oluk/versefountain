@extends('layouts.app')

@section('title', 'Welcome - VerseFountain')
@section('pageTitle', 'Home')

@section('content')
<div class="min-h-screen bg-white dark:bg-gray-900">
    <div class="w-full grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6 px-4 sm:px-6 lg:px-8 py-6">
        <!-- Main Content Area -->
        <main class="lg:col-span-2 space-y-4 sm:space-y-6">
            <!-- Page Header -->
            <div class="mb-6 sm:mb-8">
                <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white mb-2 sm:mb-3">Welcome to VerseFountain</h1>
                <p class="text-sm sm:text-base lg:text-lg text-gray-600 dark:text-gray-400 leading-relaxed max-w-2xl">
                    @auth
                        Good {{ date('H') < 12 ? 'morning' : (date('H') < 18 ? 'afternoon' : 'evening') }}, <span class="font-semibold text-blue-600 dark:text-blue-400">{{ $user->first_name ?? $user->username ?? 'there' }}</span>. Here's what's happening in your literary world today.
                    @else
                        Discover a world of poetry, books, and academic resources. Connect with a community of readers and writers.
                    @endauth
                </p>
            </div>

            <!-- Book of the Day -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm dark:shadow-md overflow-hidden border border-gray-200 dark:border-gray-700 hover:shadow-md dark:hover:shadow-lg transition-shadow">
                <div class="flex flex-col lg:flex-row">
                    <!-- Image Section -->
                    <div class="w-full lg:w-1/3 h-48 sm:h-56 lg:h-auto lg:min-h-80 bg-gradient-to-br from-amber-900 to-amber-700 dark:from-amber-800 dark:to-amber-900 flex items-center justify-center relative overflow-hidden">
                        <div class="absolute inset-0 opacity-20">
                            <svg class="w-full h-full" viewBox="0 0 100 100" preserveAspectRatio="none">
                                <defs>
                                    <pattern id="diagonal-lines" x="0" y="0" width="10" height="10" patternUnits="userSpaceOnUse">
                                        <line x1="0" y1="0" x2="10" y2="10" stroke="rgba(255,255,255,0.1)" stroke-width="1"/>
                                    </pattern>
                                </defs>
                                <rect width="100" height="100" fill="url(#diagonal-lines)"/>
                            </svg>
                        </div>
                        <div class="text-center text-white p-4 sm:p-6 relative z-10">
                            <i class="bx bx-book-open text-6xl sm:text-8xl opacity-60"></i>
                        </div>
                    </div>
                    
                    <!-- Content Section -->
                    <div class="w-full lg:w-2/3 p-4 sm:p-6 lg:p-8 flex flex-col justify-center">
                        <span class="inline-block w-fit px-3 py-1 bg-blue-100 dark:bg-blue-900/40 text-blue-700 dark:text-blue-300 text-xs font-semibold rounded-full mb-3 sm:mb-4 uppercase tracking-wide">Book of the Day</span>
                        
                        <h2 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-2 sm:mb-3 line-clamp-2">The Hill We Climb</h2>
                        
                        <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400 mb-4 sm:mb-6 leading-relaxed line-clamp-3">An inspiring call for unity and hope by Amanda Gorman. Dive into this lyrical masterpiece that captured hearts worldwide.</p>
                        
                        <div class="flex flex-col sm:flex-row gap-3 sm:gap-3 w-full">
                            <a href="/books" class="flex-1 px-4 sm:px-6 py-2.5 bg-blue-600 dark:bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 dark:hover:bg-blue-700 transition-colors shadow-sm text-center sm:text-left">
                                Read Now
                            </a>
                            <a href="/books" class="flex-1 px-4 sm:px-6 py-2.5 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 text-sm font-semibold rounded-lg hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors flex items-center justify-center sm:justify-start gap-2">
                                <i class="bx bx-book text-base sm:text-lg flex-shrink-0"></i>
                                <span class="hidden sm:inline">Library</span>
                                <span class="sm:hidden">View</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Currently Reading (for authenticated users) -->
            @auth
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm dark:shadow-md p-6 border border-gray-200 dark:border-gray-700 hover:shadow-md dark:hover:shadow-lg transition-shadow">
                <div class="flex items-center gap-4">
                    <div class="w-16 h-24 bg-gradient-to-br from-blue-400 to-purple-500 rounded-lg flex-shrink-0 flex items-center justify-center shadow-md">
                        <i class="bx bx-book text-3xl text-white"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white">The Waste Land</h3>
                        <p class="text-sm text-gray-600 dark:text-gray-400">T.S. Eliot</p>
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-xs font-medium text-gray-700 dark:text-gray-300">Reading Progress</span>
                            <span class="text-sm font-semibold text-gray-900 dark:text-white">45%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2.5">
                            <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2.5 rounded-full" style="width: 45%"></div>
                        </div>
                    </div>
                    <a href="/books" class="p-2.5 text-gray-600 dark:text-gray-400 hover:text-white hover:bg-blue-600 dark:hover:bg-blue-600 rounded-lg transition-colors">
                        <i class="bx bx-play text-xl"></i>
                    </a>
                </div>
            </div>
            @endauth

            <!-- Recommended for You -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm dark:shadow-md p-4 sm:p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">Recommended for You</h2>
                    <a href="{{ route('books.index') }}" class="text-xs sm:text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold whitespace-nowrap">View All →</a>
                </div>
                <div class="flex gap-3 sm:gap-4 overflow-x-auto pb-2">
                    @forelse($trendingBooks as $book)
                    <a href="{{ route('books.show', $book->uuid) }}" class="flex-shrink-0 w-28 sm:w-32 group">
                        <div class="w-28 sm:w-32 h-40 sm:h-48 bg-gradient-to-br from-gray-200 dark:from-gray-700 to-gray-300 dark:to-gray-800 rounded-lg flex items-center justify-center mb-2 sm:mb-3 overflow-hidden shadow-md hover:shadow-lg transition-shadow">
                            @if($book->coverImage)
                                @if(str_starts_with($book->coverImage, 'data:image') || str_starts_with($book->coverImage, 'http'))
                                    <img src="{{ $book->coverImage }}" alt="{{ $book->title }}" class="w-full h-full object-cover rounded-lg group-hover:scale-105 transition-transform">
                                @else
                                    <img src="{{ asset('storage/' . $book->coverImage) }}" alt="{{ $book->title }}" class="w-full h-full object-cover rounded-lg group-hover:scale-105 transition-transform">
                                @endif
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="bx bx-book text-3xl sm:text-4xl text-gray-400 dark:text-gray-500"></i>
                                </div>
                            @endif
                        </div>
                        <h3 class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white truncate group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $book->title }}</h3>
                        <p class="text-xs text-gray-600 dark:text-gray-400 truncate">{{ $book->author ?? 'Unknown Author' }}</p>
                    </a>
                    @empty
                    <div class="flex-shrink-0 w-28 sm:w-32">
                        <div class="w-28 sm:w-32 h-40 sm:h-48 bg-gray-100 dark:bg-gray-700 rounded-lg flex flex-col items-center justify-center mb-2 sm:mb-3 border-2 border-dashed border-gray-300 dark:border-gray-600">
                            <i class="bx bx-book text-2xl sm:text-3xl text-gray-400 dark:text-gray-500 mb-2"></i>
                            <span class="text-xs text-gray-600 dark:text-gray-400 text-center px-2">No books yet</span>
                        </div>
                    </div>
                    @endforelse
                    @if($trendingBooks->count() > 0)
                    <div class="flex-shrink-0 w-28 sm:w-32">
                        <a href="{{ route('books.index') }}" class="w-28 sm:w-32 h-40 sm:h-48 bg-gray-100 dark:bg-gray-700 rounded-lg flex flex-col items-center justify-center mb-2 sm:mb-3 border-2 border-dashed border-gray-300 dark:border-gray-600 hover:bg-gray-200 dark:hover:bg-gray-600 hover:border-blue-400 dark:hover:border-blue-400 transition-colors group cursor-pointer">
                            <i class="bx bx-plus text-3xl sm:text-4xl text-gray-400 dark:text-gray-500 mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors"></i>
                            <span class="text-xs text-gray-600 dark:text-gray-400 text-center px-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">Discover</span>
                        </a>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Trending Poetry -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm dark:shadow-md p-4 sm:p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">Trending Poetry</h2>
                    <a href="/poetry" class="text-xs sm:text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold whitespace-nowrap">View All →</a>
                </div>
                @if($trendingPoems->count() > 0)
                <div class="space-y-3 sm:space-y-4">
                    @foreach($trendingPoems->take(3) as $poem)
                    <div class="flex items-start gap-3 sm:gap-4 p-3 sm:p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors group cursor-pointer">
                        <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-100 dark:from-blue-900/40 to-blue-50 dark:to-blue-800/40 rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="bx bx-quote-left text-base sm:text-lg text-blue-600 dark:text-blue-400"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-1 sm:mb-2 flex-wrap">
                                <a href="{{ route('poetry.show', $poem) }}" class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 truncate">{{ $poem->title }}</a>
                                <span class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $poem->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-xs sm:text-sm text-gray-700 dark:text-gray-300 italic line-clamp-2">{{ Str::limit($poem->content ?? 'No content', 100) }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8 sm:py-12">
                    <i class="bx bx-file text-4xl sm:text-5xl text-gray-300 dark:text-gray-600 mb-4"></i>
                    <p class="text-sm text-gray-500 dark:text-gray-400">No poetry available yet</p>
                </div>
                @endif
            </div>

            <!-- Creator Updates (only for authenticated users) -->
            @auth
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm dark:shadow-md p-4 sm:p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">Following</h2>
                    <a href="{{ route('creators.index') }}" class="text-xs sm:text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold whitespace-nowrap">View All →</a>
                </div>
                <div class="space-y-3 sm:space-y-4">
                    @forelse($followedCreators ?? [] as $creator)
                        <a href="{{ route('profile.creator', $creator->id) }}" class="flex items-start gap-3 sm:gap-4 p-3 sm:p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors">
                            <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center flex-shrink-0 shadow-md">
                                <span class="text-white text-xs sm:text-sm font-semibold">{{ strtoupper(substr($creator->first_name ?? $creator->username, 0, 2)) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-2 mb-1 sm:mb-2 flex-wrap">
                                    <span class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white">{{ $creator->first_name ?? $creator->username }} {{ $creator->last_name ?? '' }}</span>
                                </div>
                                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">{{ $creator->poems->count() }} {{ Str::plural('poem', $creator->poems->count()) }}</p>
                            </div>
                        </a>
                    @empty
                        <div class="text-center py-6 sm:py-8">
                            <i class="bx bx-user text-3xl sm:text-4xl text-gray-300 dark:text-gray-600 mb-3"></i>
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-2">You're not following any creators yet</p>
                            <a href="{{ route('creators.index') }}" class="inline-block text-xs sm:text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">
                                Discover creators →
                            </a>
                        </div>
                    @endforelse
                </div>
            </div>
            @endauth
        </main>

        <!-- Right Sidebar -->
        <aside class="space-y-6">
            <!-- Reading Challenge -->
            @auth
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm dark:shadow-md p-4 sm:p-6 border border-gray-200 dark:border-gray-700 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-16 h-16 sm:w-24 sm:h-24 opacity-10">
                    <i class="bx bx-trophy text-6xl sm:text-8xl text-yellow-500"></i>
                </div>
                <div class="relative">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-2">Reading Challenge</h2>
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-4 sm:mb-6">You're on track! Keep it up.</p>
                    <div class="flex items-center justify-center mb-4 sm:mb-6">
                        <div class="relative w-32 h-32 sm:w-40 sm:h-40">
                            <svg class="transform -rotate-90 w-32 h-32 sm:w-40 sm:h-40">
                                <circle cx="64" cy="64" r="56" stroke="#e5e7eb" stroke-width="6" fill="none"></circle>
                                <circle cx="64" cy="64" r="56" stroke="#3b82f6" stroke-width="6" fill="none" 
                                        stroke-dasharray="352" stroke-dashoffset="211" stroke-linecap="round"></circle>
                            </svg>
                            <div class="absolute inset-0 flex flex-col items-center justify-center">
                                <span class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">12</span>
                                <span class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">of 20</span>
                            </div>
                        </div>
                    </div>
                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 text-center mb-2">12 Books read</p>
                    <p class="text-xs text-gray-500 dark:text-gray-500 text-center mb-4 sm:mb-6">Goal: 20 books</p>
                    <a href="{{ route('dashboard') }}" class="block w-full px-4 py-2 sm:py-2.5 bg-blue-600 dark:bg-blue-600 text-white text-xs sm:text-sm font-semibold rounded-lg hover:bg-blue-700 dark:hover:bg-blue-700 transition-colors text-center shadow-sm">
                        View Details
                    </a>
                </div>
            </div>
            @endauth

            <!-- Live Chatrooms -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm dark:shadow-md p-4 sm:p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">Live Chatrooms</h2>
                    @if($liveChatrooms->count() > 0)
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-xs font-semibold rounded-full">
                            <span class="w-1.5 h-1.5 bg-blue-500 rounded-full animate-pulse"></span>
                            {{ $liveChatrooms->count() }} Active
                        </span>
                    @endif
                </div>
                @if($liveChatrooms->count() > 0)
                <div class="space-y-3 sm:space-y-4">
                    @foreach($liveChatrooms as $room)
                    <div class="border-b border-gray-200 dark:border-gray-700 pb-3 sm:pb-4 last:border-0 last:pb-0">
                        <div class="flex items-start justify-between mb-2 sm:mb-3 gap-2">
                            <a href="{{ route('chatroom.show', $room) }}" class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white hover:text-blue-600 dark:hover:text-blue-400 truncate flex-1">{{ $room->name }}</a>
                            <span class="px-2 py-1 bg-green-100 dark:bg-green-900/40 text-green-700 dark:text-green-400 text-xs font-semibold rounded-full flex-shrink-0">Live</span>
                        </div>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-2 sm:mb-3">Discussing literary themes...</p>
                        <div class="flex items-center gap-2">
                            <div class="flex -space-x-2">
                                @for($i = 0; $i < min(3, $room->members->count()); $i++)
                                    <div class="w-5 h-5 sm:w-6 sm:h-6 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full border-2 border-white dark:border-gray-800 text-white text-xs font-semibold flex items-center justify-center"></div>
                                @endfor
                            </div>
                            <span class="text-xs text-gray-500 dark:text-gray-400">+{{ max(0, $room->members->count() - 3) }} others</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('chatrooms.index') }}" class="block w-full mt-4 px-4 py-2 sm:py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs sm:text-sm font-semibold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-center">
                    View All Rooms
                </a>
                @else
                <div class="text-center py-6 sm:py-8">
                    <i class="bx bx-message-dots text-3xl sm:text-4xl text-gray-300 dark:text-gray-600 mb-3"></i>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-2">No active chatrooms</p>
                    @auth
                        <a href="{{ route('chatrooms.create') }}" class="inline-block text-xs sm:text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">
                            Start a chatroom →
                        </a>
                    @else
                        <a href="{{ route('register') }}" class="inline-block text-xs sm:text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">
                            Join to participate →
                        </a>
                    @endauth
                </div>
                @endif
            </div>

            <!-- Upcoming Events -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm dark:shadow-md p-4 sm:p-6 border border-gray-200 dark:border-gray-700">
                <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white mb-4 sm:mb-6">Upcoming Events</h2>
                @if($upcomingEvents->count() > 0)
                <div class="space-y-3 sm:space-y-4">
                    @foreach($upcomingEvents as $event)
                    <div class="p-3 sm:p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors border-l-4 border-blue-600">
                        <div class="flex items-center gap-2 mb-2 flex-wrap">
                            <span class="text-xs sm:text-sm font-bold text-gray-900 dark:text-white">{{ $event->date ? $event->date->format('M d') : 'TBA' }}</span>
                            <span class="text-xs text-gray-600 dark:text-gray-400">{{ $event->date ? $event->date->format('g:i A') : '' }}</span>
                        </div>
                        <h3 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white mb-1 line-clamp-1">{{ $event->title }}</h3>
                        <p class="text-xs text-gray-600 dark:text-gray-400 mb-2 flex items-center gap-1">
                            <i class="bx bx-map text-sm flex-shrink-0"></i>
                            <span class="truncate">{{ $event->location ?? 'Online' }}</span>
                        </p>
                        <div class="flex items-center gap-2 text-xs text-gray-600 dark:text-gray-400">
                            <i class="bx bx-user flex-shrink-0"></i>
                            <span>{{ rand(15, 50) }} attending</span>
                        </div>
                    </div>
                    @endforeach
                </div>
                <a href="{{ route('events.index') }}" class="block w-full mt-4 px-4 py-2 sm:py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs sm:text-sm font-semibold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-center">
                    View All Events
                </a>
                @else
                <div class="text-center py-6 sm:py-8">
                    <i class="bx bx-calendar text-3xl sm:text-4xl text-gray-300 dark:text-gray-600 mb-3"></i>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-2">No upcoming events</p>
                    <a href="{{ route('events.index') }}" class="inline-block text-xs sm:text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">
                        Browse all events →
                    </a>
                </div>
                @endif
            </div>

            <!-- Academic Resources -->
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-sm dark:shadow-md p-4 sm:p-6 border border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between mb-4 sm:mb-6 gap-2">
                    <h2 class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">Academic Resources</h2>
                    <a href="/academics" class="text-xs sm:text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-semibold whitespace-nowrap">View All →</a>
                </div>
                <div class="space-y-2 sm:space-y-3">
                    <div class="p-3 sm:p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors border border-gray-200 dark:border-gray-700">
                        <div class="flex items-start gap-2 sm:gap-3">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-purple-100 dark:from-purple-900/40 to-purple-50 dark:to-purple-800/40 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="bx bx-file-pdf text-base sm:text-lg text-purple-600 dark:text-purple-400"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white truncate">Literature Guide</h3>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Study materials</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 sm:p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors border border-gray-200 dark:border-gray-700">
                        <div class="flex items-start gap-2 sm:gap-3">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-green-100 dark:from-green-900/40 to-green-50 dark:to-green-800/40 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="bx bx-book text-base sm:text-lg text-green-600 dark:text-green-400"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white truncate">Writing Tips</h3>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Creative writing</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-3 sm:p-4 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-colors border border-gray-200 dark:border-gray-700">
                        <div class="flex items-start gap-2 sm:gap-3">
                            <div class="w-8 h-8 sm:w-10 sm:h-10 bg-gradient-to-br from-orange-100 dark:from-orange-900/40 to-orange-50 dark:to-orange-800/40 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="bx bx-note text-base sm:text-lg text-orange-600 dark:text-orange-400"></i>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white truncate">Poetry Analysis</h3>
                                <p class="text-xs text-gray-600 dark:text-gray-400">Educational</p>
                            </div>
                        </div>
                    </div>
                </div>
                <a href="/academics" class="block w-full mt-4 px-4 py-2 sm:py-2.5 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-xs sm:text-sm font-semibold rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors text-center">
                    Browse All Resources
                </a>
            </div>
        </aside>
    </div>
</div>
@endsection
