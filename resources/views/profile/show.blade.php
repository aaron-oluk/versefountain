@extends('layouts.app')

@section('title', 'Profile - VerseFountain')
@section('pageTitle', 'My Profile')

@section('content')
    <div class="max-w-6xl mx-auto">
        <!-- Profile Header -->
        <div
            class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-4 sm:p-6 mb-4 sm:mb-6">
            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
                <div class="flex items-center sm:items-start gap-3 sm:gap-5">
                    <div class="relative flex-shrink-0">
                        <div
                            class="w-14 h-14 sm:w-20 sm:h-20 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white text-lg sm:text-2xl font-semibold">
                            {{ strtoupper(substr($user->first_name ?? ($user->username ?? 'U'), 0, 1)) }}
                        </div>
                        <div
                            class="absolute bottom-0 right-0 w-3.5 h-3.5 sm:w-5 sm:h-5 bg-green-500 rounded-full border-2 border-white dark:border-gray-900">
                        </div>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h1 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-0.5 truncate">
                            {{ $user->first_name ?? ($user->username ?? 'User') }}
                        </h1>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                            {{ '@' . ($user->username ?? 'user') }}</p>
                        <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-300 italic mt-1 hidden sm:block">"Poetry
                            is truth in its Sunday clothes."</p>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}"
                    class="flex items-center justify-center gap-2 px-3 sm:px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-200 text-xs sm:text-sm font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors w-full sm:w-auto">
                    <i class="bx bx-cog text-base sm:text-lg"></i>
                    <span>Settings</span>
                </a>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-4 gap-2 sm:gap-4 mb-4 sm:mb-6">
            <div
                class="bg-white dark:bg-gray-900 rounded-lg sm:rounded-xl border border-gray-200 dark:border-gray-800 p-2.5 sm:p-4 text-center sm:text-left">
                <p class="text-2xs sm:text-xs text-gray-500 dark:text-gray-400 uppercase mb-0.5 sm:mb-1">Books</p>
                <p class="text-base sm:text-2xl font-semibold text-gray-900 dark:text-white">{{ $booksRead }}</p>
            </div>
            <div
                class="bg-white dark:bg-gray-900 rounded-lg sm:rounded-xl border border-gray-200 dark:border-gray-800 p-2.5 sm:p-4 text-center sm:text-left">
                <p class="text-2xs sm:text-xs text-gray-500 dark:text-gray-400 uppercase mb-0.5 sm:mb-1">Following</p>
                <p class="text-base sm:text-2xl font-semibold text-gray-900 dark:text-white">{{ $following }}</p>
            </div>
            <div
                class="bg-white dark:bg-gray-900 rounded-lg sm:rounded-xl border border-gray-200 dark:border-gray-800 p-2.5 sm:p-4 text-center sm:text-left">
                <p class="text-2xs sm:text-xs text-gray-500 dark:text-gray-400 uppercase mb-0.5 sm:mb-1">Chats</p>
                <p class="text-base sm:text-2xl font-semibold text-gray-900 dark:text-white">{{ $discussions }}</p>
            </div>
            <div
                class="bg-white dark:bg-gray-900 rounded-lg sm:rounded-xl border border-gray-200 dark:border-gray-800 p-2.5 sm:p-4 text-center sm:text-left">
                <p class="text-2xs sm:text-xs text-gray-500 dark:text-gray-400 uppercase mb-0.5 sm:mb-1">Rank</p>
                <p class="text-base sm:text-2xl font-semibold text-gray-900 dark:text-white">{{ $rank }}</p>
            </div>
        </div>

        <div class="flex gap-6">
            <!-- Main Content -->
            <main class="flex-1 min-w-0">
                <!-- Profile Tabs -->
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 mb-4 sm:mb-6"
                    data-tabs>
                    <div class="p-2">
                        <nav class="flex overflow-x-auto scrollbar-hide gap-2" role="tablist">
                            <button data-tab="overview" role="tab" aria-selected="true"
                                class="tab-btn flex-1 sm:flex-none px-4 py-2 text-xs sm:text-sm font-medium text-white bg-blue-600 dark:bg-blue-500 rounded-lg whitespace-nowrap transition-all">
                                <i class="bx bx-grid-alt mr-1.5 text-sm sm:text-base"></i>
                                Overview
                            </button>
                            <button data-tab="bookshelf" role="tab" aria-selected="false"
                                class="tab-btn flex-1 sm:flex-none px-4 py-2 text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg whitespace-nowrap transition-all">
                                <i class="bx bx-book-open mr-1.5 text-sm sm:text-base"></i>
                                Bookshelf
                            </button>
                            <button data-tab="comments" role="tab" aria-selected="false"
                                class="tab-btn flex-1 sm:flex-none px-4 py-2 text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg whitespace-nowrap transition-all">
                                <i class="bx bx-comment mr-1.5 text-sm sm:text-base"></i>
                                Comments
                            </button>
                            <button data-tab="favorites" role="tab" aria-selected="false"
                                class="tab-btn flex-1 sm:flex-none px-4 py-2 text-xs sm:text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg whitespace-nowrap transition-all">
                                <i class="bx bx-heart mr-1.5 text-sm sm:text-base"></i>
                                Favorites
                            </button>
                        </nav>
                    </div>

                    <!-- Tab Panels -->
                    <div class="p-4 sm:p-6">
                        <!-- Overview Tab -->
                        <div data-tab-panel="overview" role="tabpanel" class="tab-panel">
                            <!-- Currently Reading -->
                            <div class="mb-6 sm:mb-8">
                                <div class="flex items-center justify-between mb-3 sm:mb-4">
                                    <h2 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white">Currently
                                        Reading</h2>
                                    <a href="{{ route('books.index') }}"
                                        class="text-xs sm:text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">View
                                        Log</a>
                                </div>
                                @if ($currentlyReading)
                                    <div class="flex gap-3 sm:gap-4 bg-gray-50 dark:bg-gray-800 rounded-lg p-3 sm:p-4">
                                        <div
                                            class="w-16 h-24 sm:w-20 sm:h-28 bg-gray-200 dark:bg-gray-700 rounded flex-shrink-0 flex items-center justify-center overflow-hidden">
                                            @if ($currentlyReading->coverImage)
                                                <img src="{{ $currentlyReading->coverImage }}"
                                                    alt="{{ $currentlyReading->title }}"
                                                    class="w-full h-full object-cover">
                                            @else
                                                <i class="bx bx-book text-xl sm:text-2xl text-gray-400"></i>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h3
                                                class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white mb-0.5 truncate">
                                                {{ $currentlyReading->title }}</h3>
                                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-2 sm:mb-3">
                                                {{ $currentlyReading->author }}</p>
                                            <div class="mb-2 sm:mb-3">
                                                <div class="flex items-center justify-between mb-1">
                                                    <span
                                                        class="text-2xs sm:text-xs text-gray-500 dark:text-gray-400">Progress</span>
                                                    <span
                                                        class="text-2xs sm:text-xs font-medium text-gray-900 dark:text-white">45%</span>
                                                </div>
                                                <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-1.5 sm:h-2">
                                                    <div class="bg-blue-600 h-1.5 sm:h-2 rounded-full" style="width: 45%">
                                                    </div>
                                                </div>
                                            </div>
                                            <a href="{{ route('books.show', $currentlyReading) }}"
                                                class="inline-flex items-center gap-1.5 px-3 py-1.5 sm:px-4 sm:py-2 bg-blue-600 text-white text-xs sm:text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                                <i class="bx bx-book-reader"></i>
                                                Continue
                                            </a>
                                        </div>
                                    </div>
                                @else
                                    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 sm:p-6 text-center">
                                        <i
                                            class="bx bx-book-open text-3xl sm:text-4xl text-gray-300 dark:text-gray-600 mb-2"></i>
                                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">You're not reading
                                            any books yet.</p>
                                        <a href="{{ route('books.index') }}"
                                            class="inline-block mt-2 text-xs sm:text-sm text-blue-600 dark:text-blue-400 hover:underline">Browse
                                            the library</a>
                                    </div>
                                @endif
                            </div>

                            <!-- Up Next -->
                            <div>
                                <div class="flex items-center justify-between mb-3 sm:mb-4">
                                    <h2 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white">Up Next
                                    </h2>
                                    <a href="{{ route('books.index') }}"
                                        class="text-xs sm:text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium">View
                                        All</a>
                                </div>
                                <div class="flex gap-3 overflow-x-auto pb-2 scrollbar-hide">
                                    @foreach ($trendingBooks as $book)
                                        <a href="{{ route('books.show', $book) }}"
                                            class="flex-shrink-0 w-24 sm:w-28 group">
                                            <div
                                                class="w-24 sm:w-28 h-36 sm:h-40 bg-gray-200 dark:bg-gray-700 rounded-lg mb-2 flex items-center justify-center overflow-hidden group-hover:ring-2 ring-blue-500 transition-all">
                                                @if ($book->coverImage)
                                                    <img src="{{ $book->coverImage }}" alt="{{ $book->title }}"
                                                        class="w-full h-full object-cover">
                                                @else
                                                    <i class="bx bx-book text-2xl sm:text-3xl text-gray-400"></i>
                                                @endif
                                            </div>
                                            <h3
                                                class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white truncate group-hover:text-blue-600 dark:group-hover:text-blue-400">
                                                {{ $book->title }}</h3>
                                            <p class="text-2xs sm:text-xs text-gray-500 dark:text-gray-400 truncate">
                                                {{ $book->author }}</p>
                                        </a>
                                    @endforeach
                                    <a href="{{ route('books.index') }}" class="flex-shrink-0 w-24 sm:w-28">
                                        <div
                                            class="w-24 sm:w-28 h-36 sm:h-40 bg-gray-100 dark:bg-gray-800 rounded-lg mb-2 flex flex-col items-center justify-center border-2 border-dashed border-gray-300 dark:border-gray-600 hover:border-blue-400 dark:hover:border-blue-500 hover:bg-blue-50 dark:hover:bg-gray-700 transition-colors">
                                            <i class="bx bx-plus text-2xl sm:text-3xl text-gray-400 mb-1"></i>
                                            <span
                                                class="text-2xs sm:text-xs text-gray-500 dark:text-gray-400">Discover</span>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Bookshelf Tab -->
                        <div data-tab-panel="bookshelf" role="tabpanel" class="tab-panel hidden">
                            <div class="text-center py-8 sm:py-12">
                                <i class="bx bx-book-open text-4xl sm:text-5xl text-gray-300 dark:text-gray-600 mb-3"></i>
                                <h3 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white mb-1">Your
                                    Bookshelf</h3>
                                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-4">Books you've read and
                                    saved will appear here.</p>
                                <a href="{{ route('books.index') }}"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-xs sm:text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                    <i class="bx bx-library"></i>
                                    Browse Library
                                </a>
                            </div>
                        </div>

                        <!-- Comments Tab -->
                        <div data-tab-panel="comments" role="tabpanel" class="tab-panel hidden">
                            <div class="text-center py-8 sm:py-12">
                                <i class="bx bx-comment text-4xl sm:text-5xl text-gray-300 dark:text-gray-600 mb-3"></i>
                                <h3 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white mb-1">Your
                                    Comments</h3>
                                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-4">Comments you've made on
                                    poems and books will appear here.</p>
                                <a href="{{ route('poetry.index') }}"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-xs sm:text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                    <i class="bx bx-pen"></i>
                                    Explore Poetry
                                </a>
                            </div>
                        </div>

                        <!-- Favorites Tab -->
                        <div data-tab-panel="favorites" role="tabpanel" class="tab-panel hidden">
                            <div class="text-center py-8 sm:py-12">
                                <i class="bx bx-heart text-4xl sm:text-5xl text-gray-300 dark:text-gray-600 mb-3"></i>
                                <h3 class="text-sm sm:text-base font-semibold text-gray-900 dark:text-white mb-1">Your
                                    Favorites</h3>
                                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-4">Poems and books you've
                                    liked will appear here.</p>
                                <a href="{{ route('poetry.index') }}"
                                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-xs sm:text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                    <i class="bx bx-search"></i>
                                    Discover Content
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Right Sidebar - Hidden on mobile -->
            <aside class="hidden xl:block w-72 flex-shrink-0 space-y-5">
                <!-- Creators Following -->
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-5">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-sm font-semibold text-gray-900 dark:text-white">Following</h2>
                        <a href="{{ route('creators.index') }}"
                            class="text-xs text-blue-600 dark:text-blue-400 hover:text-blue-700 font-medium">View All</a>
                    </div>
                    @if ($followedCreators->count() > 0)
                        <div class="space-y-3">
                            @foreach ($followedCreators as $creator)
                                <a href="{{ route('profile.creator', $creator) }}" class="flex items-center gap-3 group">
                                    <div
                                        class="w-9 h-9 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white text-xs font-medium">
                                        {{ strtoupper(substr($creator->first_name ?? ($creator->username ?? 'U'), 0, 1)) }}
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <h3
                                            class="text-sm font-medium text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 truncate">
                                            {{ $creator->first_name ?? $creator->username }}
                                        </h3>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">Poet</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p class="text-xs text-gray-500 dark:text-gray-400">You're not following any creators yet.</p>
                    @endif
                    <a href="{{ route('creators.index') }}"
                        class="block w-full mt-4 px-3 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-xs font-medium rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors text-center">
                        Discover Creators
                    </a>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-5">
                    <h2 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Quick Actions</h2>
                    <div class="space-y-1">
                        <a href="{{ route('poetry.create') }}"
                            class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                            <i class="bx bx-pen text-gray-400"></i>
                            Write a Poem
                        </a>
                        <a href="{{ route('books.index') }}"
                            class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                            <i class="bx bx-library text-gray-400"></i>
                            Browse Library
                        </a>
                        <a href="{{ route('chatrooms.index') }}"
                            class="flex items-center gap-3 px-3 py-2 text-sm text-gray-700 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-colors">
                            <i class="bx bx-chat text-gray-400"></i>
                            Join Discussion
                        </a>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const tabContainer = document.querySelector('[data-tabs]');
            if (!tabContainer) return;

            const tabButtons = tabContainer.querySelectorAll('[data-tab]');
            const tabPanels = tabContainer.querySelectorAll('[data-tab-panel]');

            function switchTab(targetTab) {
                // Update buttons
                tabButtons.forEach(btn => {
                    const isActive = btn.dataset.tab === targetTab;
                    btn.setAttribute('aria-selected', isActive);
                    btn.classList.toggle('text-blue-600', isActive);
                    btn.classList.toggle('dark:text-blue-400', isActive);
                    btn.classList.toggle('border-blue-600', isActive);
                    btn.classList.toggle('dark:border-blue-400', isActive);
                    btn.classList.toggle('text-gray-500', !isActive);
                    btn.classList.toggle('dark:text-gray-400', !isActive);
                    btn.classList.toggle('border-transparent', !isActive);
                });

                // Update panels
                tabPanels.forEach(panel => {
                    const isActive = panel.dataset.tabPanel === targetTab;
                    panel.classList.toggle('hidden', !isActive);
                });
            }

            tabButtons.forEach(btn => {
                btn.addEventListener('click', () => switchTab(btn.dataset.tab));
            });
        });
    </script>
@endsection
