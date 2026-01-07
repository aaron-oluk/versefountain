@extends('layouts.app')

@section('title', $creator->username . ' - Creator Profile - VerseFountain')

@php
    $publishedWorks = \App\Models\Book::where('uploadedById', $creator->id)->where('approved', true)->get();
    $latestUpdates = []; // Mock data for updates
@endphp

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Banner -->
    <div class="h-64 bg-gradient-to-r from-blue-900 via-purple-900 to-blue-800 relative mb-20">
        <div class="absolute bottom-0 left-8 transform translate-y-1/2">
            <div class="w-32 h-32 bg-white rounded-full border-4 border-white shadow-lg flex items-center justify-center text-4xl font-semibold text-blue-600">
                {{ strtoupper(substr($creator->username ?? 'U', 0, 1)) }}
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <!-- Profile Header -->
        <div class="flex items-start justify-between mb-6">
            <div class="flex items-start gap-4">
                <div class="w-24 h-24 bg-blue-600 rounded-full flex items-center justify-center text-white text-3xl font-semibold -mt-12 ml-4">
                    {{ strtoupper(substr($creator->username ?? 'U', 0, 1)) }}
                </div>
                <div class="pt-4">
                    <div class="flex items-center gap-2 mb-2">
                        <h1 class="text-3xl font-semibold text-gray-900">{{ $creator->username }}</h1>
                        <i class="bx bx-check-circle text-blue-600 text-xl"></i>
                    </div>
                    <p class="text-sm text-gray-600 mb-2">Weaving shadows into verse. Best-selling author of 'The Midnight Garden'. Exploring the quiet spaces between words.</p>
                    <div class="flex items-center gap-4 text-sm">
                        <span class="text-gray-900 font-semibold">12.5k</span>
                        <span class="text-gray-600">Followers</span>
                        <span class="text-gray-900 font-semibold">48</span>
                        <span class="text-gray-600">Works</span>
                    </div>
                </div>
            </div>
            <div class="flex gap-2">
                <button class="px-4 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">
                    Follow
                </button>
                <button class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Subscribe
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <main class="lg:col-span-2">
                <!-- Tabs -->
                <div class="border-b border-gray-200 mb-6">
                    <nav class="flex -mb-px">
                        <button class="px-4 py-3 text-sm font-medium text-blue-600 border-b-2 border-blue-600">
                            Portfolio
                        </button>
                        <button class="px-4 py-3 text-sm font-medium text-gray-600 hover:text-gray-900 border-b-2 border-transparent hover:border-gray-300">
                            Timeline
                        </button>
                        <button class="px-4 py-3 text-sm font-medium text-gray-600 hover:text-gray-900 border-b-2 border-transparent hover:border-gray-300">
                            Reviews
                        </button>
                        <button class="px-4 py-3 text-sm font-medium text-gray-600 hover:text-gray-900 border-b-2 border-transparent hover:border-gray-300 flex items-center gap-1">
                            Community
                            <span class="px-1.5 py-0.5 bg-blue-100 text-blue-700 text-xs font-semibold rounded">Pro</span>
                        </button>
                    </nav>
                </div>

                <!-- Published Works -->
                <div class="mb-8">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Published Works</h2>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View all</a>
                    </div>
                    <div class="flex gap-4 overflow-x-auto pb-2">
                        @foreach($publishedWorks->take(4) as $work)
                        <div class="flex-shrink-0 w-40">
                            <div class="w-40 h-56 bg-gray-200 rounded mb-2 flex items-center justify-center">
                                @if($work->coverImage)
                                    <img src="{{ $work->coverImage }}" alt="{{ $work->title }}" class="w-full h-full object-cover rounded">
                                @else
                                    <i class="bx bx-book text-4xl text-gray-400"></i>
                                @endif
                            </div>
                            <h3 class="text-sm font-semibold text-gray-900 truncate">{{ $work->title }}</h3>
                            <p class="text-xs text-gray-600">{{ $work->created_at->format('Y') }} • Poetry Collection</p>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Latest Updates -->
                <div>
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Latest Updates</h2>
                        <button class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded-lg transition-colors">
                            <i class="bx bx-dots-horizontal-rounded text-xl"></i>
                        </button>
                    </div>
                    <div class="space-y-4">
                        <!-- Update Card 1 -->
                        <div class="bg-white rounded-lg border border-gray-200 p-4">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                    {{ strtoupper(substr($creator->username ?? 'U', 0, 1)) }}
                                </div>
                                <div class="flex-1">
                                    <div class="flex items-center gap-2">
                                        <span class="text-sm font-medium text-gray-900">{{ $creator->username }}</span>
                                        <span class="text-xs text-gray-500">2 hours ago</span>
                                    </div>
                                </div>
                            </div>
                            <span class="inline-block px-2 py-1 bg-blue-100 text-blue-700 text-xs font-medium rounded-full mb-2">Announcement</span>
                            <p class="text-sm text-gray-700 mb-3">Thrilled to announce that the pre-order for my next collection, 'Whispers in the Glass,' will be available starting next Friday! Here is a sneak peek at the cover art. 🌙✨</p>
                            <div class="w-full h-48 bg-gray-200 rounded-lg mb-3 flex items-center justify-center">
                                <i class="bx bx-image text-4xl text-gray-400"></i>
                            </div>
                            <div class="flex items-center gap-4 text-sm text-gray-600">
                                <button class="flex items-center gap-1 hover:text-red-600">
                                    <i class="bx bx-heart"></i>
                                    <span>842</span>
                                </button>
                                <button class="flex items-center gap-1 hover:text-blue-600">
                                    <i class="bx bx-message-dots"></i>
                                    <span>56</span>
                                </button>
                                <button class="flex items-center gap-1 hover:text-gray-900">
                                    <span>Share</span>
                                    <i class="bx bx-right-arrow-alt"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </main>

            <!-- Right Sidebar -->
            <aside class="space-y-6">
                <!-- Support Section -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center gap-2 mb-3">
                        <i class="bx bx-heart text-red-500"></i>
                        <h2 class="text-lg font-semibold text-gray-900">Support {{ $creator->username }}</h2>
                    </div>
                    <p class="text-sm text-gray-600 mb-4">Get access to exclusive monthly poems, draft previews, and a private Discord channel.</p>
                    <button class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        Become a Patron
                    </button>
                </div>

                <!-- Upcoming Events -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Upcoming Events</h2>
                        <a href="#" class="text-xs text-blue-600 hover:text-blue-700 font-medium">Calendar</a>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <p class="text-xs font-medium text-gray-900 mb-1">OCT 24</p>
                            <h3 class="text-sm font-semibold text-gray-900 mb-1">Live Poetry Reading</h3>
                            <p class="text-xs text-gray-600">Online • 7:00 PM EST</p>
                        </div>
                        <div>
                            <p class="text-xs font-medium text-gray-900 mb-1">NOV 05</p>
                            <h3 class="text-sm font-semibold text-gray-900 mb-1">Book Signing: NYC</h3>
                            <p class="text-xs text-gray-600">Strand Bookstore</p>
                        </div>
                    </div>
                </div>

                <!-- Top Readers -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Top Readers</h2>
                    <div class="flex -space-x-2 mb-3">
                        @for($i = 0; $i < 5; $i++)
                            <div class="w-8 h-8 bg-blue-500 rounded-full border-2 border-white"></div>
                        @endfor
                        <div class="w-8 h-8 bg-gray-300 rounded-full border-2 border-white flex items-center justify-center text-xs text-gray-600">+42</div>
                    </div>
                    <p class="text-xs text-gray-600">Join the reading challenge to get on the leaderboard!</p>
                </div>

                <!-- Subscriber Chat -->
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-2">Subscriber Chat</h2>
                    <div class="flex items-center gap-2 mb-2">
                        <div class="w-2 h-2 bg-green-500 rounded-full"></div>
                        <p class="text-sm text-gray-700">Live discussion about 'Starlight Ink' is happening now.</p>
                    </div>
                    <p class="text-xs text-gray-600">18 Online</p>
                </div>
            </aside>
        </div>
    </div>
</div>
@endsection

