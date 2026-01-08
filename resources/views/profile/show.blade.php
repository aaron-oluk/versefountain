@extends('layouts.app')

@section('title', 'Profile - VerseFountain')

@php $pageTitle = 'My Profile'; @endphp

@section('content')
<div class="flex gap-6 max-w-6xl mx-auto">
    <!-- Main Content -->
    <main class="flex-1 min-w-0">
        <!-- Profile Header -->
        <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
            <div class="flex items-start justify-between flex-wrap gap-4">
                <div class="flex items-start gap-6">
                    <div class="relative">
                        <div class="w-24 h-24 bg-blue-600 rounded-full flex items-center justify-center text-white text-3xl font-semibold">
                            {{ strtoupper(substr($user->first_name ?? $user->username ?? 'U', 0, 1)) }}
                        </div>
                        <div class="absolute bottom-0 right-0 w-6 h-6 bg-green-500 rounded-full border-4 border-white"></div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-semibold text-gray-900 mb-1">{{ $user->first_name ?? $user->username ?? 'User' }}</h1>
                        <p class="text-sm text-gray-600 mb-2">{{ '@' . ($user->username ?? 'user') }}</p>
                        <p class="text-sm text-gray-700 italic">"Poetry is truth in its Sunday clothes."</p>
                    </div>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">
                        <i class="bx bx-edit mr-2"></i>
                        Edit Profile
                    </a>
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
                        <a href="{{ route('books.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View Log</a>
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
                            </div>
                            <a href="{{ route('books.show', $currentlyReading) }}" class="inline-block px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                Continue Reading
                            </a>
                        </div>
                    </div>
                    @else
                    <p class="text-gray-500 text-sm">You're not reading any books yet. <a href="{{ route('books.index') }}" class="text-blue-600 hover:underline">Browse the library</a></p>
                    @endif
                </div>

                <!-- Up Next -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Up Next</h2>
                        <a href="{{ route('books.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All</a>
                    </div>
                    <div class="flex gap-4 overflow-x-auto pb-2">
                        @foreach($trendingBooks as $book)
                        <a href="{{ route('books.show', $book) }}" class="flex-shrink-0 w-32 group">
                            <div class="w-32 h-48 bg-gray-200 rounded mb-2 flex items-center justify-center group-hover:ring-2 ring-blue-500 transition-all">
                                @if($book->coverImage)
                                    <img src="{{ $book->coverImage }}" alt="{{ $book->title }}" class="w-full h-full object-cover rounded">
                                @else
                                    <i class="bx bx-book text-3xl text-gray-400"></i>
                                @endif
                            </div>
                            <h3 class="text-sm font-semibold text-gray-900 truncate group-hover:text-blue-600">{{ $book->title }}</h3>
                            <p class="text-xs text-gray-600 truncate">{{ $book->author }}</p>
                        </a>
                        @endforeach
                        <a href="{{ route('books.index') }}" class="flex-shrink-0 w-32">
                            <div class="w-32 h-48 bg-gray-100 rounded mb-2 flex flex-col items-center justify-center border-2 border-dashed border-gray-300 hover:border-blue-400 hover:bg-blue-50 transition-colors">
                                <i class="bx bx-plus text-3xl text-gray-400 mb-2"></i>
                                <span class="text-xs text-gray-600 text-center px-2">Discover</span>
                            </div>
                        </a>
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
                <a href="{{ route('creators.index') }}" class="text-xs text-blue-600 hover:text-blue-700 font-medium uppercase">View All</a>
            </div>
            @if($followedCreators->count() > 0)
            <div class="space-y-4">
                @foreach($followedCreators as $creator)
                <a href="{{ route('profile.creator', $creator) }}" class="flex items-center justify-between group">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                            {{ strtoupper(substr($creator->first_name ?? $creator->username ?? 'U', 0, 1)) }}
                        </div>
                        <div>
                            <h3 class="text-sm font-semibold text-gray-900 group-hover:text-blue-600">{{ $creator->first_name ?? $creator->username }}</h3>
                            <p class="text-xs text-gray-600">Poet</p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
            @else
            <p class="text-sm text-gray-500">You're not following any creators yet.</p>
            @endif
            <a href="{{ route('creators.index') }}" class="block w-full mt-4 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors text-center">
                Discover Creators
            </a>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg border border-gray-200 p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Quick Actions</h2>
            <div class="space-y-2">
                <a href="{{ route('poetry.create') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">
                    <i class="bx bx-pen mr-3 text-gray-400"></i>
                    Write a Poem
                </a>
                <a href="{{ route('books.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">
                    <i class="bx bx-library mr-3 text-gray-400"></i>
                    Browse Library
                </a>
                <a href="{{ route('chatrooms.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">
                    <i class="bx bx-message-dots mr-3 text-gray-400"></i>
                    Join Discussion
                </a>
                <a href="{{ route('settings.index') }}" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">
                    <i class="bx bx-cog mr-3 text-gray-400"></i>
                    Settings
                </a>
            </div>
        </div>
    </aside>
</div>
@endsection
