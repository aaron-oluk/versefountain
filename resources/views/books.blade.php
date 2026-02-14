@extends('layouts.app')

@section('title', 'Library - VerseFountain')
@section('pageTitle', 'Library')

@section('content')
    <div class="max-w-7xl mx-auto">
        <!-- Header with Create Button -->
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Library</h1>
                <p class="text-gray-600 dark:text-gray-400 mt-1">Discover and share literary works</p>
            </div>
            @auth
                <a href="{{ url('/books/create') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="bx bx-plus text-lg mr-1"></i>
                    Add Book
                </a>
            @endauth
        </div>

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
                        class="text-sm bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-600 dark:text-gray-300">
                        <option value="latest" {{ $sort === 'latest' ? 'selected' : '' }}>Sort: Newest</option>
                        <option value="oldest" {{ $sort === 'oldest' ? 'selected' : '' }}>Sort: Oldest</option>
                        <option value="title" {{ $sort === 'title' ? 'selected' : '' }}>Sort: A-Z</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Trending Now -->
        @if($trendingBooks->count() > 0 && !$genre)
            <div class="mb-10 sm:mb-12">
                <div class="flex items-center gap-2 mb-6">
                    <i class="bx bx-trending-up text-blue-600 dark:text-blue-400 text-xl"></i>
                    <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 dark:text-white">Trending Now</h2>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                    @foreach($trendingBooks as $index => $book)
                        <a href="{{ route('books.show', $book) }}"
                            class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden group hover:shadow-lg dark:hover:shadow-xl transition-all">
                            <!-- Cover Image Section -->
                            <div class="h-56 sm:h-64 bg-gray-100 dark:bg-gray-800 relative overflow-hidden">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="absolute inset-0 bg-gray-200 dark:bg-gray-800 flex items-center justify-center">
                                        <i class="bx bx-book text-6xl text-gray-400 dark:text-gray-700"></i>
                                    </div>
                                @endif
                                <!-- Badge -->
                                <span class="absolute top-4 left-4 px-3 py-1.5 bg-blue-600 text-white text-xs font-semibold rounded-lg">{{ ['Editor\'s Pick', 'Popular', 'New Release'][$index] ?? 'New' }}</span>
                            </div>
                            <!-- Content Section -->
                            <div class="p-5 sm:p-6">
                                <h3 class="text-lg sm:text-xl font-semibold text-gray-900 dark:text-white mb-1 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $book->title }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">By {{ $book->author }}</p>
                                @if($book->genre)
                                    <span class="inline-block px-3 py-1 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-xs font-medium rounded-lg mb-4">{{ $book->genre }}</span>
                                @endif
                                @if($book->description)
                                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-2">{{ Str::limit($book->description, 80) }}</p>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- All Books -->
        <div>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 dark:text-white">{{ $genre ? ucfirst($genre) . ' Books' : 'All Books' }}</h2>
                <span class="text-sm text-gray-600 dark:text-gray-400">{{ $allBooks->total() }} books</span>
            </div>

            @if($allBooks->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 sm:gap-6">
                    @foreach($allBooks as $book)
                        <a href="{{ route('books.show', $book) }}"
                            class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden group hover:shadow-lg dark:hover:shadow-xl transition-all">
                            <div class="aspect-[3/4] bg-gray-100 dark:bg-gray-800 relative overflow-hidden">
                                @if($book->cover_image)
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}"
                                        class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-100 dark:bg-gray-800">
                                        <i class="bx bx-book text-5xl text-gray-300 dark:text-gray-700"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="p-4 sm:p-5">
                                <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-1 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                                    {{ $book->title }}</h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">{{ $book->author }}</p>
                                @if($book->genre)
                                    <span
                                        class="inline-block px-3 py-1 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-xs font-medium rounded-lg">{{ $book->genre }}</span>
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