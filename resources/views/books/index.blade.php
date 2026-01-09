@extends('layouts.app')

@section('title', 'Library - VerseFountain')
@section('pageTitle', 'Library')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Library</h1>
                    <p class="text-gray-600 dark:text-gray-400 mt-1">Discover and share literary works</p>
                </div>
                @auth
                    <!-- Desktop Create Button -->
                    <a href="{{ url('/books/create') }}"
                       class="hidden sm:inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors whitespace-nowrap">
                        <i class="bx bx-plus text-lg mr-1"></i>
                        Add Book
                    </a>
                @endauth
            </div>
        </div>

        @auth
        <!-- Mobile FAB -->
        <a href="{{ url('/books/create') }}" class="sm:hidden fixed bottom-20 right-4 z-40 w-14 h-14 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-lg flex items-center justify-center transition-all hover:scale-110">
            <i class="bx bx-plus text-2xl"></i>
        </a>
        @endauth

        <!-- Filter Bar -->
        <div class="flex flex-wrap items-center gap-3 mb-6">
            <span class="text-sm text-gray-500 dark:text-gray-400">Filter by:</span>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('books.index') }}"
                    class="px-4 py-1.5 {{ !$genre || $genre === 'all' ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700' }} text-sm font-medium rounded-full transition-colors">All</a>
                @foreach($genres->take(5) as $g)
                    <a href="{{ route('books.index', ['genre' => $g]) }}"
                        class="px-4 py-1.5 {{ $genre === $g ? 'bg-blue-600 text-white' : 'bg-white dark:bg-gray-800 text-gray-600 dark:text-gray-300 border border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700' }} text-sm font-medium rounded-full transition-colors">{{ $g }}</a>
                @endforeach
            </div>
            <div class="ml-auto">
                <form action="{{ route('books.index') }}" method="GET" id="sortForm">
                    <input type="hidden" name="genre" value="{{ $genre }}">
                    <select name="sort" onchange="document.getElementById('sortForm').submit()"
                        class="text-sm bg-white dark:bg-gray-800 border-2 border-gray-200 dark:border-gray-700 rounded-lg px-4 py-2 pr-10 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-gray-900 dark:text-white hover:border-gray-300 dark:hover:border-gray-600 transition-colors cursor-pointer font-medium appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 20 20%27%3E%3Cpath stroke=%27%236B7280%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%271.5%27 d=%27m6 8 4 4 4-4%27/%3E%3C/svg%3E')] bg-[length:1.25rem] bg-[center_right_0.5rem] bg-no-repeat">
                        <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Sort: Newest</option>
                        <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Sort: Oldest</option>
                        <option value="title" {{ $sort === 'title' ? 'selected' : '' }}>Sort: A-Z</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Trending Now -->
        @if($trendingBooks->count() > 0 && !$genre)
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-4">
                    <i class="bx bx-trending-up text-orange-500 text-xl"></i>
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Trending Now</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($trendingBooks as $index => $book)
                        <a href="{{ route('books.show', $book->uuid) }}"
                            class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden group hover:shadow-md transition-shadow">
                            <div class="h-48 bg-gray-100 dark:bg-gray-800 relative overflow-hidden">
                                @if($book->coverImage)
                                    <img src="{{ asset('storage/' . $book->coverImage) }}" alt="{{ $book->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div
                                        class="absolute inset-0 bg-gray-200 dark:bg-gray-700 flex items-center justify-center">
                                        <i class="bx bx-book text-5xl text-gray-400 dark:text-gray-600"></i>
                                    </div>
                                @endif
                                @if($index === 0)
                                    <span
                                        class="absolute top-3 left-3 px-2.5 py-1 bg-blue-600 text-white text-[10px] font-semibold rounded-lg uppercase">Editor's
                                        Pick</span>
                                @elseif($index === 1)
                                    <span
                                        class="absolute top-3 left-3 px-2.5 py-1 bg-blue-600 text-white text-[10px] font-semibold rounded-lg uppercase">Popular</span>
                                @else
                                    <span
                                        class="absolute top-3 left-3 px-2.5 py-1 bg-blue-600 text-white text-[10px] font-semibold rounded-lg uppercase">New
                                        Release</span>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="text-base font-semibold text-gray-900 dark:text-white mb-1 truncate">{{ $book->title }}</h3>
                                <p class="text-sm text-gray-500 dark:text-gray-400">By {{ $book->author }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- All Books -->
        <div>
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white">{{ $genre ? ucfirst($genre) . ' Books' : 'All Books' }}</h2>
                <span class="text-sm text-gray-500 dark:text-gray-400">{{ $allBooks->total() }} books</span>
            </div>

            @if($allBooks->count() > 0)
                <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                    @foreach($allBooks as $book)
                        <a href="{{ route('books.show', $book->uuid) }}"
                            class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 overflow-hidden group hover:shadow-md transition-shadow">
                            <div class="aspect-[3/4] bg-gray-100 dark:bg-gray-800 relative overflow-hidden">
                                @if($book->coverImage)
                                    <img src="{{ asset('storage/' . $book->coverImage) }}" alt="{{ $book->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center">
                                        <i class="bx bx-book text-4xl text-gray-400"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="p-3">
                                <h3 class="text-sm font-medium text-gray-900 dark:text-white truncate group-hover:text-blue-600 transition-colors">
                                    {{ $book->title }}</h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400 truncate">{{ $book->author }}</p>
                                @if($book->genre)
                                    <span
                                        class="inline-block mt-1 px-2 py-0.5 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-[10px] rounded-full">{{ $book->genre }}</span>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $allBooks->links() }}
                </div>
            @else
                <div class="bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-12 text-center">
                    <i class="bx bx-book text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-2">No books found</h3>
                    <p class="text-gray-500 dark:text-gray-400">Try adjusting your filters or check back later.</p>
                </div>
            @endif
        </div>
    </div>
@endsection