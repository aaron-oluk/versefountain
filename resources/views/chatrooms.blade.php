@extends('layouts.app')

@section('title', 'Community - VerseFountain')

@section('content')
    @php
        $chatrooms = App\Models\ChatRoom::with('members')->latest()->get();
        $userChatrooms = auth()->check() ? auth()->user()->chatRooms ?? collect() : collect();
        $trendingBooks = App\Models\Book::where('approved', true)->take(3)->get();
        $upcomingEvent = App\Models\Event::where('date', '>=', now())->orderBy('date', 'asc')->first();
        
        // Mock pending invites for now - you'll need to implement this based on your invite system
        $pendingInvites = [
            [
                'room_name' => 'The Inner Circle',
                'inviter' => 'Sarah J.',
                'message' => "We'd love your input on the new anthology."
            ],
            [
                'room_name' => 'Manuscript Review',
                'inviter' => 'Editor_Mike',
                'message' => 'Private critique session for Chapter 5.'
            ]
        ];
    @endphp

    <div class="min-h-screen bg-gray-50">
        <!-- Three Column Layout -->
        <div class="flex flex-col lg:flex-row gap-6 max-w-[1920px] mx-auto px-4 sm:px-6 lg:px-8 py-6">
            
            <!-- Left Sidebar -->
            <aside class="w-full lg:w-64 flex-shrink-0 lg:block">
                <!-- Browse Section -->
                <div class="mb-8">
                    <h2 class="text-sm font-semibold text-gray-900 mb-1">Browse</h2>
                    <p class="text-xs text-gray-500 mb-4">Filter by Topic</p>
                    <nav class="space-y-1">
                        <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-blue-600 bg-blue-50 rounded-lg">
                            <i class="bx bx-envelope mr-3 text-lg"></i>
                            Invites
                            @if(count($pendingInvites) > 0)
                                <span class="ml-auto bg-red-500 text-white text-xs font-semibold px-2 py-0.5 rounded-full">{{ count($pendingInvites) }}</span>
                            @endif
                        </a>
                        <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg">
                            <i class="bx bx-group mr-3 text-lg"></i>
                            All Discussions
                        </a>
                        <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg">
                            <i class="bx bx-message-dots mr-3 text-lg"></i>
                            My Rooms
                        </a>
                        <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg">
                            <i class="bx bx-microphone mr-3 text-lg"></i>
                            Poetry Slams
                        </a>
                        <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg">
                            <i class="bx bx-book mr-3 text-lg"></i>
                            Book Clubs
                        </a>
                        <a href="#" class="flex items-center px-3 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 rounded-lg">
                            <i class="bx bx-check-circle mr-3 text-lg"></i>
                            Author Q&A
                        </a>
                    </nav>
                </div>

                <!-- My Communities Section -->
                <div>
                    <h2 class="text-sm font-semibold text-gray-900 mb-4">My Communities</h2>
                    <nav class="space-y-2">
                        <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-3"></span>
                            Classic Lit Lounge
                        </a>
                        <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">
                            <span class="w-2 h-2 bg-gray-400 rounded-full mr-3"></span>
                            Haiku Daily
                        </a>
                        <a href="#" class="flex items-center px-3 py-2 text-sm text-gray-700 hover:bg-gray-100 rounded-lg">
                            <i class="bx bx-lock-alt mr-3 text-gray-500"></i>
                            Secret Writers Guild
                        </a>
                    </nav>
                </div>
            </aside>

            <!-- Main Content Area -->
            <main class="flex-1 min-w-0">
                <!-- Pending Invites Section -->
                @if(count($pendingInvites) > 0)
                <div class="mb-8">
                    <div class="flex items-center mb-4">
                        <i class="bx bx-envelope text-blue-600 text-xl mr-2"></i>
                        <h2 class="text-xl font-semibold text-gray-900">Pending Invites</h2>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($pendingInvites as $invite)
                        <div class="bg-white rounded-lg border border-gray-200 p-6 relative overflow-hidden">
                            <div class="absolute top-0 right-0 w-32 h-32 opacity-10">
                                <i class="bx bx-lock-alt text-8xl text-purple-600"></i>
                            </div>
                            <div class="relative">
                                <div class="flex items-center mb-3">
                                    <i class="bx bx-lock-alt text-purple-600 text-2xl mr-2"></i>
                                    <h3 class="text-lg font-semibold text-gray-900">{{ $invite['room_name'] }}</h3>
                                </div>
                                <p class="text-sm text-gray-600 mb-2">Invited by <strong>{{ $invite['inviter'] }}</strong></p>
                                <p class="text-sm text-gray-700 italic mb-4">"{{ $invite['message'] }}"</p>
                                <div class="flex gap-2">
                                    <button class="px-4 py-2 bg-purple-600 text-white text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors">
                                        Accept
                                    </button>
                                    <button class="px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition-colors">
                                        Decline
                                    </button>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Explore Open Rooms Section -->
                <div>
                    <div class="mb-4">
                        <h2 class="text-xl font-semibold text-gray-900 mb-1">Explore Open Rooms</h2>
                        <p class="text-sm text-gray-600">Join public conversations with fellow readers and authors.</p>
                    </div>

                    <!-- Tabs -->
                    <div class="flex gap-2 mb-6 border-b border-gray-200 overflow-x-auto">
                        <button class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 border-b-2 border-transparent hover:border-gray-300 transition-colors whitespace-nowrap">
                            Trending
                        </button>
                        <button class="px-4 py-2 text-sm font-medium text-blue-600 border-b-2 border-blue-600 whitespace-nowrap">
                            Newest
                        </button>
                        <button class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 border-b-2 border-transparent hover:border-gray-300 transition-colors whitespace-nowrap">
                            Creator Rooms
                        </button>
                        <button class="px-4 py-2 text-sm font-medium text-gray-600 hover:text-gray-900 border-b-2 border-transparent hover:border-gray-300 transition-colors whitespace-nowrap">
                            Live Readings
                        </button>
                    </div>

                    <!-- Room Listings -->
                    <div class="space-y-4">
                        @foreach($chatrooms->take(5) as $index => $room)
                        <div class="bg-white rounded-lg border border-gray-200 p-4 sm:p-6 hover:shadow-md transition-shadow">
                            <div class="flex flex-col sm:flex-row gap-4 sm:gap-6">
                                <div class="flex-1">
                                    <div class="flex items-center gap-3 mb-2">
                                        @if($index === 0)
                                            <span class="px-2.5 py-0.5 bg-blue-100 text-blue-700 text-xs font-semibold rounded-full">BOOK CLUB</span>
                                        @elseif($index === 1)
                                            <span class="px-2.5 py-0.5 bg-purple-100 text-purple-700 text-xs font-semibold rounded-full">LIVE EVENT</span>
                                        @elseif($index === 2)
                                            <span class="px-2.5 py-0.5 bg-orange-100 text-orange-700 text-xs font-semibold rounded-full">AUTHOR Q&A</span>
                                        @endif
                                        <span class="text-xs text-gray-600">OPEN</span>
                                        @if($index === 1)
                                            <span class="text-xs text-red-600">((•)) Live Now</span>
                                        @else
                                            <span class="text-xs text-gray-600">• {{ $room->members->count() }} Online</span>
                                        @endif
                                        @if($index === 1)
                                            <i class="bx bx-check-circle text-blue-600"></i>
                                        @endif
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-900 mb-2">
                                        {{ $room->name }}
                                        @if($index === 0)
                                            <span class="text-sm font-normal text-gray-600">(Book Club)</span>
                                        @elseif($index === 1)
                                            <span class="text-sm font-normal text-gray-600">(Live Event)</span>
                                        @endif
                                    </h3>
                                    <p class="text-sm text-gray-600 mb-4 line-clamp-2">{{ $room->description }}</p>
                                    <div class="flex items-center gap-4">
                                        @if($index === 0)
                                            <div class="flex -space-x-2">
                                                @for($i = 0; $i < 3; $i++)
                                                    <div class="w-8 h-8 bg-blue-500 rounded-full border-2 border-white"></div>
                                                @endfor
                                                <div class="w-8 h-8 bg-gray-300 rounded-full border-2 border-white flex items-center justify-center text-xs text-gray-600">+5</div>
                                            </div>
                                        @endif
                                        @if($index === 1)
                                            <button class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                                Listen In
                                            </button>
                                            <span class="text-xs text-gray-600">128 listening</span>
                                        @else
                                            <button class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                                Join Room
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <div class="w-full sm:w-32 h-48 sm:h-32 flex-shrink-0 rounded-lg overflow-hidden bg-gray-100">
                                    @if($index === 0)
                                        <div class="w-full h-full bg-gradient-to-br from-blue-100 to-blue-200 flex items-center justify-center">
                                            <i class="bx bx-book text-4xl text-blue-600"></i>
                                        </div>
                                    @elseif($index === 1)
                                        <div class="w-full h-full bg-gradient-to-br from-purple-900 to-purple-700 flex items-center justify-center">
                                            <i class="bx bx-microphone text-4xl text-white"></i>
                                        </div>
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-gray-200 to-gray-300 flex items-center justify-center">
                                            <i class="bx bx-message-dots text-4xl text-gray-600"></i>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </main>

            <!-- Right Sidebar -->
            <aside class="w-full xl:w-80 flex-shrink-0 xl:block">
                <!-- Trending Books Section -->
                <div class="bg-white rounded-lg border border-gray-200 p-6 mb-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Trending Books this Week</h2>
                    <div class="space-y-4">
                        @foreach($trendingBooks as $book)
                        <div class="flex gap-3">
                            <div class="w-16 h-20 bg-gray-200 rounded flex-shrink-0 flex items-center justify-center">
                                @if($book->coverImage)
                                    <img src="{{ $book->coverImage }}" alt="{{ $book->title }}" class="w-full h-full object-cover rounded">
                                @else
                                    <i class="bx bx-book text-2xl text-gray-400"></i>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-sm font-semibold text-gray-900 truncate">{{ $book->title }}</h3>
                                <p class="text-xs text-gray-600 mb-1">{{ $book->author }}</p>
                                <p class="text-xs text-blue-600 font-medium">{{ rand(5, 15) }} active rooms</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- Upcoming Event Section -->
                @if($upcomingEvent)
                <div class="bg-white rounded-lg border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Upcoming Event</h2>
                    <div class="w-full h-48 bg-gray-200 rounded-lg mb-4 flex items-center justify-center overflow-hidden">
                        @if($upcomingEvent->image ?? false)
                            <img src="{{ $upcomingEvent->image }}" alt="{{ $upcomingEvent->title }}" class="w-full h-full object-cover">
                        @else
                            <i class="bx bx-calendar-event text-4xl text-gray-400"></i>
                        @endif
                    </div>
                    <h3 class="text-base font-semibold text-gray-900 mb-2">{{ $upcomingEvent->title }}</h3>
                    <p class="text-sm text-gray-600 mb-3">{{ $upcomingEvent->description }}</p>
                    <div class="flex items-center text-sm text-gray-600 mb-4">
                        <i class="bx bx-calendar mr-2"></i>
                        <span>{{ $upcomingEvent->date->format('F j, Y') }}, {{ $upcomingEvent->date->format('g:i A') }}</span>
                    </div>
                    <button class="w-full px-4 py-2 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition-colors">
                        Set Reminder
                    </button>
                </div>
                @endif
            </aside>
        </div>
    </div>
@endsection
