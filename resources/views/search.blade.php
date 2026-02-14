@extends('layouts.app')

@section('title', 'Search Results - VerseFountain')
@section('pageTitle', 'Search Results')

@section('content')
<div class="max-w-6xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-900 mb-2">Search Results</h1>
    <p class="text-gray-600 mb-6">Showing results for "<span class="font-medium">{{ $query }}</span>"</p>

    @if($books->isEmpty() && $poems->isEmpty() && $creators->isEmpty())
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <i class="bx bx-search-alt text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No results found</h3>
            <p class="text-gray-500">Try searching with different keywords</p>
        </div>
    @else
        <!-- Books Section -->
        @if($books->isNotEmpty())
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="bx bx-book mr-2 text-blue-600"></i>
                    Books ({{ $books->count() }})
                </h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4">
                    @foreach($books as $book)
                        <a href="{{ route('books.show', $book->id) }}" class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                            <div class="aspect-[3/4] bg-gradient-to-br from-blue-100 to-purple-100 flex items-center justify-center">
                                @if($book->coverImage)
                                    <img src="{{ asset('storage/' . $book->coverImage) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                                @else
                                    <i class="bx bx-book text-4xl text-blue-300"></i>
                                @endif
                            </div>
                            <div class="p-3">
                                <h3 class="font-medium text-gray-900 text-sm truncate">{{ $book->title }}</h3>
                                <p class="text-xs text-gray-500 truncate">{{ $book->author }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Poems Section -->
        @if($poems->isNotEmpty())
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="bx bx-pen mr-2 text-purple-600"></i>
                    Poetry ({{ $poems->count() }})
                </h2>
                <div class="grid gap-4">
                    @foreach($poems as $poem)
                        <a href="{{ route('poetry.show', $poem->id) }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow">
                            <h3 class="font-semibold text-gray-900">{{ $poem->title }}</h3>
                            <p class="text-sm text-gray-500 mt-1">by {{ $poem->author->first_name ?? $poem->author->username ?? 'Unknown' }}</p>
                            <p class="text-sm text-gray-600 mt-2 line-clamp-2">{{ Str::limit(strip_tags($poem->content), 150) }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Creators Section -->
        @if($creators->isNotEmpty())
            <div class="mb-8">
                <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="bx bx-user-circle mr-2 text-green-600"></i>
                    Creators ({{ $creators->count() }})
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($creators as $creator)
                        <a href="{{ route('profile.creator', $creator->id) }}" class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 hover:shadow-md transition-shadow flex items-center space-x-4">
                            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($creator->first_name ?? $creator->username ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="font-medium text-gray-900">{{ $creator->first_name ?? $creator->username }} {{ $creator->last_name ?? '' }}</h3>
                                <p class="text-sm text-gray-500">{{ '@' . $creator->username }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    @endif
</div>
@endsection
