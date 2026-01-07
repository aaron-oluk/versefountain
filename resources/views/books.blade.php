@extends('layouts.app')

@section('title', 'Browse - VerseFountain')

@php
    $trendingBooks = \App\Models\Book::where('approved', true)->latest()->take(3)->get();
    $topPoetry = \App\Models\Book::where('approved', true)->where('genre', 'Poetry')->take(5)->get();
@endphp

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header with Search -->
    <div class="bg-white border-b border-gray-200 mb-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center gap-4">
                <div class="flex-1 relative">
                    <input type="text" placeholder="Search titles, authors, genres..." 
                           class="w-full pl-10 pr-20 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-sm">
                    <i class="bx bx-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <button class="absolute right-2 top-1/2 transform -translate-y-1/2 px-2 py-1 bg-gray-100 text-gray-600 text-xs rounded border border-gray-300 flex items-center gap-1">
                        <i class="bx bx-keyboard"></i>
                        <span>K</span>
                    </button>
                </div>
                <button class="relative p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                    <i class="bx bx-bell text-xl"></i>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
            </div>
        </div>
    </div>

    <div class="flex gap-6 max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Left Sidebar -->
        <aside class="hidden lg:block w-64 flex-shrink-0">
            <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                        <i class="bx bx-book text-white text-xl"></i>
                    </div>
                    <div>
                        <h2 class="text-base font-semibold text-gray-900">E-Library</h2>
                    </div>
                </div>
            </div>
            <nav class="space-y-1">
                <a href="/books" class="flex items-center px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg">
                    <i class="bx bx-search mr-3"></i>
                    Browse
                </a>
                <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg">
                    <i class="bx bx-book mr-3"></i>
                    My Library
                </a>
                <a href="{{ route('chatrooms.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg">
                    <i class="bx bx-message-dots mr-3"></i>
                    Chatrooms
                </a>
                <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg">
                    <i class="bx bx-group mr-3"></i>
                    Creators
                </a>
            </nav>
            <div class="mt-8">
                <div class="flex items-center gap-3 p-3">
                    <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-xs font-medium">
                        {{ strtoupper(substr(auth()->user()->username ?? 'A', 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-900">{{ auth()->user()->username ?? 'Alex Morgan' }}</p>
                        <p class="text-xs text-gray-600">Premium Member</p>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 min-w-0">
            <!-- Filter and Sort -->
            <div class="mb-6">
                <div class="flex items-center gap-4 mb-4">
                    <span class="text-sm text-gray-700">Filter by:</span>
                    <div class="flex gap-2 flex-wrap">
                        <button class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg">All</button>
                        <button class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200">Books</button>
                        <button class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200">Poetry</button>
                        <button class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200">Romance</button>
                        <button class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200">Sci-Fi</button>
                        <button class="px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200">Haiku</button>
                    </div>
                    <select class="ml-auto text-sm border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option>Sort: Popular</option>
                        <option>Sort: Newest</option>
                        <option>Sort: Alphabetical</option>
                    </select>
                </div>
            </div>

            <!-- Trending Now -->
            <div class="mb-8">
                <div class="flex items-center gap-2 mb-4">
                    <i class="bx bx-trending-up text-orange-500"></i>
                    <h2 class="text-xl font-semibold text-gray-900">Trending Now</h2>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    @foreach($trendingBooks as $index => $book)
                    <div class="bg-white rounded-lg border border-gray-200 overflow-hidden">
                        <div class="h-64 bg-gradient-to-br from-gray-800 to-gray-900 flex items-center justify-center relative">
                            @if($book->coverImage)
                                <img src="{{ $book->coverImage }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                            @else
                                <i class="bx bx-book text-6xl text-gray-400"></i>
                            @endif
                            @if($index === 0)
                                <span class="absolute top-4 left-4 px-3 py-1 bg-blue-600 text-white text-xs font-semibold rounded-full">EDITOR'S PICK</span>
                            @elseif($index === 1)
                                <span class="absolute top-4 left-4 px-3 py-1 bg-purple-600 text-white text-xs font-semibold rounded-full">LIVE EVENT</span>
                            @else
                                <span class="absolute top-4 left-4 px-3 py-1 bg-green-600 text-white text-xs font-semibold rounded-full">NEW RELEASE</span>
                            @endif
                        </div>
                        <div class="p-4">
                            <h3 class="text-lg font-semibold text-white mb-1">{{ $book->title }}</h3>
                            <p class="text-sm text-gray-300">By {{ $book->author }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Top Poetry -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-semibold text-gray-900">Top Poetry</h2>
                    <a href="/books?genre=Poetry" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All →</a>
                </div>
                <div class="flex gap-4 overflow-x-auto pb-2">
                    @foreach($topPoetry as $book)
                    <div class="flex-shrink-0 w-40">
                        <div class="w-40 h-56 bg-gray-200 rounded mb-2 flex items-center justify-center overflow-hidden">
                            @if($book->coverImage)
                                <img src="{{ $book->coverImage }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                            @else
                                <i class="bx bx-book text-4xl text-gray-400"></i>
                            @endif
                        </div>
                        <h3 class="text-sm font-semibold text-gray-900 truncate">{{ $book->title }}</h3>
                        <p class="text-xs text-gray-600 truncate">{{ $book->author }}</p>
                        <div class="flex items-center gap-1 mt-1">
                            <i class="bx bxs-star text-yellow-400 text-xs"></i>
                            <span class="text-xs text-gray-600">4.8</span>
                        </div>
                    </div>
                    @endforeach
                    <div class="flex-shrink-0 w-40">
                        <div class="w-40 h-56 bg-gray-100 rounded mb-2 flex flex-col items-center justify-center border-2 border-dashed border-gray-300">
                            <i class="bx bx-grid-alt text-4xl text-gray-400 mb-2"></i>
                            <p class="text-xs text-gray-600 text-center px-2">Explore all 1,240 Poetry books</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Creator Spotlight -->
            <div class="mb-8">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">Creator Spotlight</h2>
                        <p class="text-sm text-gray-600">Join the conversation with trending authors</p>
                    </div>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All Creators</a>
                </div>
                <!-- Creator cards would go here -->
            </div>
        </main>
    </div>
</div>
@endsection
