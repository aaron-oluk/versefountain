@extends('layouts.app')

@section('title', 'Dashboard - VerseFountain')
@section('pageTitle', 'Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Greeting Section -->
        <div class="mb-4 sm:mb-6">
            <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 dark:text-white mb-1">{{ $greeting }},
                {{ $user->first_name ?? $user->username }}</h2>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Here's what's happening in your literary world
                today.</p>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 sm:gap-6">
            <!-- Left Column - Main Content -->
            <div class="lg:col-span-2 space-y-4 sm:space-y-5">
                <!-- Book of the Day -->
                @if ($featuredBook)
                    <div
                        class="bg-white dark:bg-gray-900 rounded-xl shadow-sm overflow-hidden border border-gray-100 dark:border-gray-800">
                        <div class="flex flex-col sm:flex-row">
                            <div
                                class="sm:w-2/5 h-40 sm:h-auto relative overflow-hidden bg-gradient-to-br from-blue-100 to-purple-100 dark:from-blue-900/30 dark:to-purple-900/30">
                                @if ($featuredBook->coverImage)
                                    <img src="{{ asset('storage/' . $featuredBook->coverImage) }}"
                                        alt="{{ $featuredBook->title }}" class="w-full h-full object-cover">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="bx bx-book text-4xl sm:text-6xl text-blue-300 dark:text-blue-600"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="sm:w-3/5 p-4 sm:p-5">
                                <span
                                    class="inline-block px-2 py-0.5 sm:px-2.5 sm:py-1 bg-blue-50 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 text-2xs sm:text-xs font-semibold rounded-md mb-2 sm:mb-3 uppercase tracking-wide">Book
                                    of the Day</span>
                                <h2 class="text-base sm:text-xl font-semibold text-gray-900 dark:text-white mb-1 sm:mb-2">
                                    {{ $featuredBook->title }}</h2>
                                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-1">by
                                    {{ $featuredBook->author }}</p>
                                <p
                                    class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-3 sm:mb-4 leading-relaxed line-clamp-2">
                                    {{ Str::limit($featuredBook->description, 120) }}</p>
                                <div class="flex gap-2">
                                    <a href="{{ route('books.read', $featuredBook->id) }}"
                                        class="px-3 sm:px-4 py-1.5 sm:py-2 bg-blue-600 text-white text-xs sm:text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                        Read Now
                                    </a>
                                    <a href="{{ route('books.show', $featuredBook->id) }}"
                                        class="px-3 sm:px-4 py-1.5 sm:py-2 bg-blue-50 dark:bg-gray-800 text-blue-600 dark:text-blue-400 text-xs sm:text-sm font-medium rounded-lg hover:bg-blue-100 dark:hover:bg-gray-700 transition-colors flex items-center gap-1.5">
                                        <i class="bx bx-info-circle text-sm sm:text-base"></i>
                                        Details
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Recommended for You -->
                <div
                    class="bg-white dark:bg-gray-900 rounded-xl shadow-sm p-4 sm:p-5 border border-gray-100 dark:border-gray-800">
                    <div class="flex items-center justify-between mb-3 sm:mb-4">
                        <h2 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white">Recommended for You
                        </h2>
                        <a href="{{ route('books.index') }}"
                            class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">View
                            All</a>
                    </div>
                    @if ($recommendedBooks->count() > 0)
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">
                            @foreach ($recommendedBooks as $book)
                                <a href="{{ route('books.show', $book->id) }}" class="flex-shrink-0 group">
                                    <div
                                        class="w-full aspect-[2/3] bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800 rounded-lg mb-2 overflow-hidden shadow-sm group-hover:shadow-md transition-shadow">
                                        @if ($book->coverImage)
                                            <img src="{{ asset('storage/' . $book->coverImage) }}"
                                                alt="{{ $book->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center">
                                                <i class="bx bx-book text-xl sm:text-2xl text-gray-400"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <h3
                                        class="text-2xs sm:text-xs font-medium text-gray-900 dark:text-white truncate group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                        {{ $book->title }}</h3>
                                    <p class="text-2xs text-gray-500 dark:text-gray-400 truncate">{{ $book->author }}</p>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 text-center py-6 sm:py-8">No books
                            available yet. Check back soon!</p>
                    @endif
                </div>

                <!-- Two Column Section -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                    <!-- Trending Poetry -->
                    <div
                        class="bg-white dark:bg-gray-900 rounded-xl shadow-sm p-4 sm:p-5 border border-gray-100 dark:border-gray-800">
                        <div class="flex items-center justify-between mb-3 sm:mb-4">
                            <h2 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white">Trending Poetry
                            </h2>
                            <a href="{{ route('poetry.index') }}"
                                class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-700 font-medium">View
                                All</a>
                        </div>
                        @forelse($trendingPoems as $poem)
                            <a href="{{ route('poetry.show', $poem->id) }}"
                                class="flex items-start gap-3 {{ !$loop->last ? 'mb-3 pb-3 sm:mb-4 sm:pb-4 border-b border-gray-100 dark:border-gray-800' : '' }} hover:bg-gray-50 dark:hover:bg-gray-800 -mx-2 px-2 py-2 rounded-lg transition-colors">
                                <div
                                    class="w-9 h-9 sm:w-10 sm:h-10 bg-blue-50 dark:bg-blue-900/30 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="bx bx-pen text-sm sm:text-base text-blue-600 dark:text-blue-400"></i>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <span
                                        class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white block truncate">{{ $poem->title }}</span>
                                    <p class="text-2xs sm:text-xs text-gray-500 dark:text-gray-400">by
                                        {{ $poem->author->first_name ?? ($poem->author->username ?? 'Unknown') }}</p>
                                </div>
                            </a>
                        @empty
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 text-center py-4">No trending
                                poems yet.</p>
                        @endforelse
                    </div>

                    <!-- Creator Updates -->
                    <div
                        class="bg-white dark:bg-gray-900 rounded-xl shadow-sm p-4 sm:p-5 border border-gray-100 dark:border-gray-800">
                        <div class="flex items-center justify-between mb-3 sm:mb-4">
                            <h2 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white">Following</h2>
                            <a href="{{ route('creators.index') }}"
                                class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-700 font-medium">Find
                                More</a>
                        </div>
                        @forelse($followedCreators as $creator)
                            <a href="{{ route('profile.creator', $creator->id) }}"
                                class="flex items-start gap-3 {{ !$loop->last ? 'mb-3 pb-3 sm:mb-4 sm:pb-4 border-b border-gray-100 dark:border-gray-800' : '' }} hover:bg-gray-50 dark:hover:bg-gray-800 -mx-2 px-2 py-2 rounded-lg transition-colors">
                                <div
                                    class="w-9 h-9 sm:w-10 sm:h-10 bg-gradient-to-br from-pink-400 to-purple-500 rounded-full flex items-center justify-center flex-shrink-0 overflow-hidden">
                                    <span
                                        class="text-white text-xs sm:text-sm font-medium">{{ strtoupper(substr($creator->first_name ?? $creator->username, 0, 2)) }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <span
                                        class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white block truncate">{{ $creator->first_name ?? $creator->username }}
                                        {{ $creator->last_name ?? '' }}</span>
                                    <p class="text-2xs sm:text-xs text-gray-500 dark:text-gray-400">
                                        {{ $creator->poems->count() }} poems</p>
                                </div>
                            </a>
                        @empty
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 text-center py-4">You're not
                                following anyone yet.</p>
                            <a href="{{ route('creators.index') }}"
                                class="block text-center text-xs sm:text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 font-medium mt-2">Discover
                                Creators</a>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Right Sidebar -->
            <div class="space-y-4 sm:space-y-5">
                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm p-4 sm:p-5 border border-gray-100 dark:border-gray-800">
                    <h2 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white mb-3 sm:mb-4">Quick Actions</h2>
                    <div class="space-y-2">
                        <a href="{{ route('poetry.create') }}"
                            class="flex items-center gap-3 px-3 sm:px-4 py-2.5 sm:py-3 bg-blue-50 dark:bg-blue-900/30 text-blue-700 dark:text-blue-400 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/50 transition-colors">
                            <i class="bx bx-pen text-lg sm:text-xl"></i>
                            <span class="text-xs sm:text-sm font-medium">Write a Poem</span>
                        </a>
                        <a href="{{ route('books.index') }}"
                            class="flex items-center gap-3 px-3 sm:px-4 py-2.5 sm:py-3 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="bx bx-book-open text-lg sm:text-xl"></i>
                            <span class="text-xs sm:text-sm font-medium">Browse Library</span>
                        </a>
                        <a href="{{ route('chatrooms.index') }}"
                            class="flex items-center gap-3 px-3 sm:px-4 py-2.5 sm:py-3 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors">
                            <i class="bx bx-message-square-dots text-lg sm:text-xl"></i>
                            <span class="text-xs sm:text-sm font-medium">Join Chatroom</span>
                        </a>
                    </div>
                </div>

                <!-- Live Chatrooms -->
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm p-4 sm:p-5 border border-gray-100 dark:border-gray-800">
                    <div class="flex items-center justify-between mb-3 sm:mb-4">
                        <h2 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white">Live Chatrooms</h2>
                        <span class="text-2xs sm:text-xs text-blue-600 dark:text-blue-400 font-medium bg-blue-50 dark:bg-blue-900/30 px-2 py-0.5 rounded-full">{{ $liveChatrooms->count() }} Active</span>
                    </div>
                    <div class="space-y-3 sm:space-y-4">
                        @forelse($liveChatrooms as $chatroom)
                            <a href="{{ route('chatroom.show', $chatroom->id) }}"
                                class="block {{ !$loop->last ? 'pb-3 sm:pb-4 border-b border-gray-100 dark:border-gray-800' : '' }}">
                                <div class="flex items-start justify-between mb-1">
                                    <h3 class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white">{{ $chatroom->name }}</h3>
                                    <span class="flex items-center gap-1 text-2xs sm:text-xs text-green-600 dark:text-green-400">
                                        <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                        Live
                                    </span>
                                </div>
                                <p class="text-2xs sm:text-xs text-gray-500 dark:text-gray-400 mb-2">{{ Str::limit($chatroom->description, 50) }}</p>
                                <div class="flex items-center gap-2">
                                    <div class="flex -space-x-1.5">
                                        @for ($i = 0; $i < min(3, $chatroom->members_count); $i++)
                                            <div class="w-4 h-4 sm:w-5 sm:h-5 bg-{{ ['blue', 'purple', 'pink'][$i] }}-500 rounded-full border-2 border-white dark:border-gray-900"></div>
                                        @endfor
                                    </div>
                                    @if ($chatroom->members_count > 3)
                                        <span class="text-2xs sm:text-xs text-gray-500 dark:text-gray-400">+{{ $chatroom->members_count - 3 }} others</span>
                                    @endif
                                </div>
                            </a>
                        @empty
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 text-center py-4">No active chatrooms.</p>
                        @endforelse
                    </div>
                    <a href="{{ route('chatrooms.index') }}"
                        class="block w-full mt-3 sm:mt-4 px-3 sm:px-4 py-2 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-xs sm:text-sm font-medium rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors text-center">
                        View All Rooms
                    </a>
                </div>

                <!-- Upcoming Events -->
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm p-4 sm:p-5 border border-gray-100 dark:border-gray-800">
                    <h2 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white mb-3 sm:mb-4">Upcoming Events</h2>
                    <div class="space-y-3 sm:space-y-4">
                        @forelse($upcomingEvents as $event)
                            <div class="flex gap-3">
                                <div class="w-10 h-12 sm:w-12 sm:h-14 bg-blue-50 dark:bg-blue-900/30 rounded-lg flex flex-col items-center justify-center flex-shrink-0">
                                    <span class="text-sm sm:text-lg font-bold text-blue-600 dark:text-blue-400">{{ $event->date->format('d') }}</span>
                                    <span class="text-2xs text-blue-600 dark:text-blue-400 uppercase">{{ $event->date->format('M') }}</span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white mb-0.5 truncate">{{ $event->title }}</h3>
                                    <p class="text-2xs sm:text-xs text-gray-500 dark:text-gray-400">{{ $event->date->format('g:i A') }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 text-center py-4">No upcoming events.</p>
                        @endforelse
                    </div>
                    <a href="{{ route('events.index') }}"
                        class="block w-full mt-3 sm:mt-4 text-xs text-blue-600 dark:text-blue-400 hover:text-blue-700 font-medium text-center">
                        View All Events
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection
