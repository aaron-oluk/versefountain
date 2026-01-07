@extends('layouts.app')

@section('title', 'Profile - VerseFountain')

@php
    $user = $user ?? auth()->user();
    $booksRead = 42; // Mock data
    $following = $user->following()->count() ?? 156;
    $discussions = 85; // Mock data
    $rank = 'Scribe Lvl. 5'; // Mock data
    $currentlyReading = \App\Models\Book::where('approved', true)->first();
    $trendingBooks = \App\Models\Book::where('approved', true)->take(3)->get();
    $followedCreators = $user->following()->take(3)->get();
@endphp

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="flex gap-6 max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8 py-6">
        <!-- Left Sidebar -->
        <aside class="hidden lg:block w-64 flex-shrink-0">
            <!-- User Mini Profile -->
            <div class="bg-white rounded-lg border border-gray-200 p-4 mb-6">
                <div class="flex flex-col items-center mb-4">
                    <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center text-white text-xl font-semibold mb-2">
                        {{ strtoupper(substr($user->first_name ?? $user->username ?? 'U', 0, 1)) }}
                    </div>
                    <h3 class="text-sm font-semibold text-gray-900">{{ $user->username ?? 'User' }}</h3>
                    <p class="text-xs text-gray-600">Reader | Supporter</p>
                </div>
            </div>

            <!-- Navigation -->
            <nav class="space-y-1 mb-6">
                <a href="/profile" class="flex items-center px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg">
                    <i class="bx bx-user mr-3"></i>
                    My Profile
                </a>
                <a href="/books" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg">
                    <i class="bx bx-book mr-3"></i>
                    My Library
                </a>
                <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg">
                    <i class="bx bx-list-ul mr-3"></i>
                    Reading Lists
                </a>
                <a href="{{ route('chatrooms.index') }}" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg">
                    <i class="bx bx-message-dots mr-3"></i>
                    Discussions
                </a>
                <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg">
                    <i class="bx bx-group mr-3"></i>
                    Creators Following
                </a>
            </nav>

            <!-- Premium Plan -->
            <div class="bg-blue-50 rounded-lg p-4">
                <h3 class="text-sm font-semibold text-gray-900 mb-1">Premium Plan</h3>
                <p class="text-xs text-gray-600 mb-3">Support creators directly</p>
                <button class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Upgrade
                </button>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 min-w-0">
            <!-- Profile Header -->
            <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                <div class="flex items-start justify-between">
                    <div class="flex items-start gap-6">
                        <div class="relative">
                            <div class="w-24 h-24 bg-blue-600 rounded-full flex items-center justify-center text-white text-3xl font-semibold">
                                {{ strtoupper(substr($user->first_name ?? $user->username ?? 'U', 0, 1)) }}
                            </div>
                            <div class="absolute bottom-0 right-0 w-6 h-6 bg-green-500 rounded-full border-4 border-white"></div>
                        </div>
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-900 mb-1">{{ $user->username ?? 'User' }}</h1>
                            <p class="text-sm text-gray-600 mb-2">Reader | Creator Supporter</p>
                            <p class="text-sm text-gray-700 italic">"Poetry is truth in its Sunday clothes."</p>
                        </div>
                    </div>
                    <div class="flex gap-2">
                        <button class="flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">
                            <i class="bx bx-edit mr-2"></i>
                            Edit Profile
                        </button>
                        <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                            <i class="bx bx-share-alt text-xl"></i>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <p class="text-xs text-gray-600 uppercase mb-1">Books Read</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $booksRead }}</p>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <p class="text-xs text-gray-600 uppercase mb-1">Following</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $following }}</p>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <p class="text-xs text-gray-600 uppercase mb-1">Discussions</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $discussions }}</p>
                </div>
                <div class="bg-white rounded-lg border border-gray-200 p-4">
                    <p class="text-xs text-gray-600 uppercase mb-1">Rank</p>
                    <p class="text-2xl font-semibold text-gray-900">{{ $rank }}</p>
                </div>
            </div>

            <!-- Profile Tabs -->
            <div class="bg-white rounded-lg border border-gray-200 mb-6">
                <div class="border-b border-gray-200">
                    <nav class="flex -mb-px">
                        <button class="px-6 py-4 text-sm font-medium text-blue-600 border-b-2 border-blue-600">
                            Overview
                        </button>
                        <button class="px-6 py-4 text-sm font-medium text-gray-600 hover:text-gray-900 border-b-2 border-transparent hover:border-gray-300">
                            Bookshelf
                        </button>
                        <button class="px-6 py-4 text-sm font-medium text-gray-600 hover:text-gray-900 border-b-2 border-transparent hover:border-gray-300">
                            Comments
                        </button>
                        <button class="px-6 py-4 text-sm font-medium text-gray-600 hover:text-gray-900 border-b-2 border-transparent hover:border-gray-300">
                            Favorites
                        </button>
                    </nav>
                </div>

                <div class="p-6">
                    <!-- Currently Reading -->
                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-900">Currently Reading</h2>
                            <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View Log</a>
                        </div>
                        @if($currentlyReading)
                        <div class="flex gap-4 bg-gray-50 rounded-lg p-4">
                            <div class="w-20 h-28 bg-gray-200 rounded flex-shrink-0 flex items-center justify-center">
                                @if($currentlyReading->coverImage)
                                    <img src="{{ $currentlyReading->coverImage }}" alt="{{ $currentlyReading->title }}" class="w-full h-full object-cover rounded">
                                @else
                                    <i class="bx bx-book text-2xl text-gray-400"></i>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h3 class="text-base font-semibold text-gray-900 mb-1">{{ $currentlyReading->title }}</h3>
                                <p class="text-sm text-gray-600 mb-3">{{ $currentlyReading->author }}</p>
                                <div class="mb-3">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="text-xs text-gray-600">Progress</span>
                                        <span class="text-xs font-medium text-gray-900">45%</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: 45%"></div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Page 124 of 276</p>
                                </div>
                                <div class="flex gap-2">
                                    <button class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                        Update Progress
                                    </button>
                                    <button class="px-4 py-2 bg-white border border-blue-600 text-blue-600 text-sm font-medium rounded-lg hover:bg-blue-50 transition-colors">
                                        View Discussion
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Recent Contributions -->
                    <div class="mb-8">
                        <h2 class="text-lg font-semibold text-gray-900 mb-4">Recent Contributions</h2>
                        <div class="space-y-4">
                            <div class="flex gap-3">
                                <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="bx bx-message-dots text-blue-600"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-sm font-medium text-gray-900">Commented on</span>
                                        <a href="#" class="text-sm text-blue-600 hover:underline">The Raven Discussion</a>
                                        <span class="text-xs text-gray-500">2h ago</span>
                                    </div>
                                    <p class="text-sm text-gray-700 italic mb-2">"The rhythm here is fascinating, specifically how the internal rhyme scheme drives the narrative forward with such urgency..."</p>
                                    <div class="flex items-center gap-4 text-xs text-gray-600">
                                        <span>12 Likes</span>
                                        <span>3 Replies</span>
                                    </div>
                                </div>
                            </div>
                            <div class="flex gap-3">
                                <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center flex-shrink-0">
                                    <i class="bx bx-star text-purple-600"></i>
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2 mb-1">
                                        <span class="text-sm font-medium text-gray-900">Reviewed</span>
                                        <a href="#" class="text-sm text-blue-600 hover:underline">Modernist Literature</a>
                                        <span class="text-xs text-gray-500">1d ago</span>
                                    </div>
                                    <div class="flex items-center gap-1 mb-2">
                                        @for($i = 0; $i < 5; $i++)
                                            <i class="bx bxs-star text-yellow-400 text-sm"></i>
                                        @endfor
                                    </div>
                                    <p class="text-sm text-gray-700 italic">"A comprehensive collection that really captures the fragmented spirit of the era. Highly recommended for students."</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Up Next -->
                    <div>
                        <div class="flex items-center justify-between mb-4">
                            <h2 class="text-lg font-semibold text-gray-900">Up Next</h2>
                            <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All</a>
                        </div>
                        <div class="flex gap-4 overflow-x-auto pb-2">
                            @foreach($trendingBooks as $book)
                            <div class="flex-shrink-0 w-32">
                                <div class="w-32 h-48 bg-gray-200 rounded mb-2 flex items-center justify-center">
                                    @if($book->coverImage)
                                        <img src="{{ $book->coverImage }}" alt="{{ $book->title }}" class="w-full h-full object-cover rounded">
                                    @else
                                        <i class="bx bx-book text-3xl text-gray-400"></i>
                                    @endif
                                </div>
                                <h3 class="text-sm font-semibold text-gray-900 truncate">{{ $book->title }}</h3>
                                <p class="text-xs text-gray-600 truncate">{{ $book->author }}</p>
                            </div>
                            @endforeach
                            <div class="flex-shrink-0 w-32">
                                <div class="w-32 h-48 bg-gray-100 rounded mb-2 flex flex-col items-center justify-center border-2 border-dashed border-gray-300">
                                    <i class="bx bx-plus text-3xl text-gray-400 mb-2"></i>
                                    <span class="text-xs text-gray-600 text-center px-2">Discover</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>

        <!-- Right Sidebar -->
        <aside class="hidden xl:block w-80 flex-shrink-0">
            <!-- Creators Following -->
            <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-lg font-semibold text-gray-900">Creators Following</h2>
                    <a href="#" class="text-xs text-blue-600 hover:text-blue-700 font-medium uppercase">View All</a>
                </div>
                <div class="space-y-4">
                    @foreach($followedCreators as $creator)
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                {{ strtoupper(substr($creator->username ?? 'U', 0, 1)) }}
                            </div>
                            <div>
                                <h3 class="text-sm font-semibold text-gray-900">{{ $creator->username }}</h3>
                                <p class="text-xs text-gray-600">Poet • New York</p>
                            </div>
                        </div>
                        <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                            <i class="bx bx-paper-plane text-lg"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
                <button class="w-full mt-4 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                    Discover More Creators
                </button>
            </div>

            <!-- Trending in Poetry -->
            <div class="bg-white rounded-lg border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Trending in Poetry</h2>
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <span class="text-lg font-bold text-gray-900">#1</span>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">The Hill We Climb</h3>
                            <p class="text-xs text-gray-600">Amanda Gorman</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-lg font-bold text-gray-900">#2</span>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">Devotions</h3>
                            <p class="text-xs text-gray-600">Mary Oliver</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="text-lg font-bold text-gray-900">#3</span>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900">Milk and Honey</h3>
                            <p class="text-xs text-gray-600">Rupi Kaur</p>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>
@endsection
