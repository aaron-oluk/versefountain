@extends('layouts.app')

@section('title', 'Events - VerseFountain')

@section('content')
    <div class="min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
            <!-- Page Header -->
            <div class="mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl sm:text-4xl font-semibold text-gray-900 dark:text-white mb-2">Events</h1>
                        <p class="text-base text-gray-600 dark:text-gray-400 leading-relaxed max-w-2xl">Discover poetry readings, workshops, and literary events</p>
                    </div>
                    @auth
                        <!-- Desktop Create Button -->
                        <a href="{{ url('/events/create') }}"
                           class="hidden sm:inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors whitespace-nowrap">
                            <i class="bx bx-plus text-lg mr-1"></i>
                            Create Event
                        </a>
                    @endauth
                </div>
            </div>

            @auth
            <!-- Mobile FAB -->
            <a href="{{ url('/events/create') }}" class="sm:hidden fixed bottom-20 right-4 z-40 w-14 h-14 bg-blue-600 hover:bg-blue-700 text-white rounded-full shadow-lg flex items-center justify-center transition-all hover:scale-110">
                <i class="bx bx-plus text-2xl"></i>
            </a>
            @endauth

            <!-- Search and Filter Section -->
            <div class="bg-white dark:bg-gray-800 rounded-lg p-5 shadow-sm mb-8">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                    <!-- Search -->
                    <div class="sm:col-span-2 lg:col-span-1">
                        <label for="search"
                            class="block text-xs font-normal text-gray-600 dark:text-gray-400 mb-1.5 uppercase tracking-wide">Search
                            Events</label>
                        <div class="relative">
                            <input type="text" id="search" placeholder="Search events, locations, or organizers..."
                                class="w-full pl-9 pr-3 py-2 border border-gray-300 dark:border-gray-600 focus:border-blue-600 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 focus:outline-none">
                            <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                                <i class="bx bx-search text-base text-gray-400"></i>
                            </div>
                        </div>
                    </div>

                    <!-- Category Filter -->
                    <div>
                        <label for="category"
                            class="block text-xs font-normal text-gray-600 dark:text-gray-400 mb-1.5 uppercase tracking-wide">Category</label>
                        <select id="category"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 focus:border-blue-600 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none appearance-none cursor-pointer">
                            <option value="">All Categories</option>
                            <option value="poetry-reading">Poetry Reading</option>
                            <option value="workshop">Workshop</option>
                            <option value="book-launch">Book Launch</option>
                            <option value="conference">Conference</option>
                        </select>
                    </div>

                    <!-- Date Filter -->
                    <div>
                        <label for="date"
                            class="block text-xs font-normal text-gray-600 dark:text-gray-400 mb-1.5 uppercase tracking-wide">Date</label>
                        <select id="date"
                            class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 focus:border-blue-600 text-sm bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:outline-none appearance-none cursor-pointer">
                            <option value="">All Dates</option>
                            <option value="today">Today</option>
                            <option value="tomorrow">Tomorrow</option>
                            <option value="this-week">This Week</option>
                            <option value="this-month">This Month</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Featured Events -->
            @if($featuredEvents->count() > 0)
                <div class="mb-10">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-6">Featured Events</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
                        @foreach($featuredEvents as $event)
                            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm transition-colors overflow-hidden">
                                <div class="h-40 sm:h-48 bg-gray-100 dark:bg-gray-700 flex items-center justify-center">
                                    <i class="bx bx-calendar text-6xl text-gray-400 dark:text-gray-500"></i>
                                </div>
                                <div class="p-4 sm:p-6">
                                    <div class="flex items-center justify-between mb-3 pb-3 border-b border-gray-200 dark:border-gray-700">
                                        <span
                                            class="text-xs text-gray-600 dark:text-gray-400 uppercase tracking-wide">{{ ucfirst(str_replace('_', ' ', $event->category ?? 'General')) }}</span>
                                        <span
                                            class="text-xs text-gray-500 dark:text-gray-400">{{ ($event->is_free ?? false) || ($event->ticket_price ?? 0) == 0 ? 'Free' : '$' . ($event->ticket_price ?? 0) }}</span>
                                    </div>
                                    <h3 class="font-normal text-gray-900 dark:text-white mb-1 text-sm sm:text-base">
                                        <a href="{{ route('events.show', $event) }}" class="hover:text-gray-700 dark:hover:text-gray-300">
                                            {{ $event->title }}
                                        </a>
                                    </h3>
                                    <p class="text-gray-600 dark:text-gray-400 text-xs sm:text-sm mb-3 font-light">
                                        {{ Str::limit($event->description ?? 'No description', 80) }}</p>
                                    <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 mb-3">
                                        <i class="bx bx-map mr-1 text-sm"></i>
                                        <span>{{ $event->location ?? 'Location TBA' }}</span>
                                    </div>
                                    <div class="flex items-center justify-between">
                                        <span
                                            class="text-xs text-gray-500 dark:text-gray-400">{{ $event->date ? $event->date->format('M d, Y • g:i A') : 'Date TBA' }}</span>
                                        @auth
                                            <button onclick="registerForEvent('{{ $event->uuid }}', '{{ $event->title }}', {{ ($event->is_free ?? false) ? 'true' : 'false' }}, {{ $event->ticket_price ?? 0 }})"
                                                class="px-3 py-1 bg-blue-600 text-white rounded-md text-xs font-normal hover:bg-blue-700 transition-colors">
                                                Register
                                            </button>
                                        @else
                                            <a href="{{ route('login') }}"
                                                class="px-3 py-1 bg-blue-600 text-white rounded-md text-xs font-normal hover:bg-blue-700 transition-colors inline-block">
                                                Register
                                            </a>
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Upcoming Events -->
            <div class="mb-10 sm:mb-12">
                <h2 class="text-xl sm:text-2xl font-light text-gray-800 dark:text-white mb-6 sm:mb-8 tracking-wide">Upcoming Events</h2>
                @if($upcomingEvents->count() > 0)
                    <div class="space-y-5 sm:space-y-6">
                        @foreach($upcomingEvents as $event)
                            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-md p-4 sm:p-6 transition-colors">
                                <div class="flex items-start space-x-4">
                                    <div
                                        class="w-16 h-16 sm:w-20 sm:h-20 bg-gray-100 dark:bg-gray-700 flex items-center justify-center flex-shrink-0">
                                        <i class="bx bx-calendar text-4xl sm:text-5xl text-gray-400 dark:text-gray-500"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center justify-between mb-2">
                                            <span
                                                class="text-xs text-gray-600 dark:text-gray-400 uppercase tracking-wide">{{ ucfirst(str_replace('_', ' ', $event->category ?? 'General')) }}</span>
                                            <span
                                                class="text-xs text-gray-500 dark:text-gray-400">{{ ($event->is_free ?? false) || ($event->ticket_price ?? 0) == 0 ? 'Free' : '$' . ($event->ticket_price ?? 0) }}</span>
                                        </div>
                                        <h3 class="font-normal text-gray-900 dark:text-white text-sm sm:text-base mb-1">
                                            <a href="{{ route('events.show', $event) }}" class="hover:text-gray-700 dark:hover:text-gray-300">
                                                {{ $event->title }}
                                            </a>
                                        </h3>
                                        <p class="text-gray-600 dark:text-gray-400 text-xs sm:text-sm mb-3 font-light">
                                            {{ Str::limit($event->description ?? 'No description', 100) }}</p>
                                        <div class="flex items-center text-xs text-gray-500 dark:text-gray-400 mb-3">
                                            <i class="bx bx-map mr-1 text-sm"></i>
                                            <span>{{ $event->location ?? 'Location TBA' }}</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span
                                                class="text-xs text-gray-500 dark:text-gray-400">{{ $event->date ? $event->date->format('M d, Y • g:i A') : 'Date TBA' }}</span>
                                            @auth
                                                <button onclick="registerForEvent('{{ $event->uuid }}', '{{ $event->title }}', {{ ($event->is_free ?? false) ? 'true' : 'false' }}, {{ $event->ticket_price ?? 0 }})"
                                                    class="px-3 py-1 bg-blue-600 text-white rounded-md text-xs font-normal hover:bg-blue-700 transition-colors">
                                                    Register
                                                </button>
                                            @else
                                                <a href="{{ route('login') }}"
                                                    class="px-3 py-1 bg-blue-600 text-white rounded-md text-xs font-normal hover:bg-blue-700 transition-colors inline-block">
                                                    Register
                                                </a>
                                            @endauth
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    @if($upcomingEvents->hasPages())
                        <div class="text-center mt-10 sm:mt-12">
                            {{ $upcomingEvents->links() }}
                        </div>
                    @endif
                @else
                    <div class="text-center py-16 sm:py-20">
                        <div class="max-w-md mx-auto">
                            <i class="bx bx-calendar text-6xl text-gray-300 dark:text-gray-600 mb-4"></i>
                            <h3 class="text-lg font-normal text-gray-700 dark:text-gray-300 mb-2">No upcoming events</h3>
                            <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Check back soon for new events and workshops.</p>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Event Categories -->
            @if($categories->count() > 0)
                <div class="mb-10 sm:mb-12">
                    <h2 class="text-xl sm:text-2xl font-light text-gray-800 dark:text-white mb-6 sm:mb-8 tracking-wide">Browse by Category</h2>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                        @foreach($categories->take(4) as $category)
                            @php
                                $categoryCount = \App\Models\Event::where('category', $category)->where('date', '>', now())->count();
                                $icons = [
                                    'poetry' => 'bx-book',
                                    'workshop' => 'bx-bulb',
                                    'book_launch' => 'bx-book-reader',
                                    'lecture' => 'bx-chalkboard',
                                    'general' => 'bx-calendar',
                                ];
                                $icon = $icons[$category] ?? 'bx-calendar';
                            @endphp
                            <a href="/events?category={{ urlencode($category) }}"
                                class="bg-white dark:bg-gray-800 shadow-sm rounded-md p-4 sm:p-6 transition-colors cursor-pointer block">
                                <div class="w-10 h-10 sm:w-12 sm:h-12 bg-gray-100 dark:bg-gray-700 flex items-center justify-center mx-auto mb-3">
                                    <i class="bx {{ $icon }} text-xl sm:text-2xl text-gray-600 dark:text-gray-400"></i>
                                </div>
                                <h3 class="font-normal text-gray-900 dark:text-white text-sm sm:text-base">
                                    {{ ucfirst(str_replace('_', ' ', $category)) }}</h3>
                                <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mt-1">{{ $categoryCount }}
                                    {{ $categoryCount === 1 ? 'event' : 'events' }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Registration Modal -->
    <div id="registrationModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
        <div class="bg-white dark:bg-gray-900 rounded-xl max-w-md w-full p-6 shadow-xl">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Confirm Registration</h3>
                <button onclick="closeModal()" class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                    <i class="bx bx-x text-2xl"></i>
                </button>
            </div>
            
            <div id="modalContent">
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">You are about to register for:</p>
                <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4 mb-4">
                    <h4 id="modalEventTitle" class="font-semibold text-gray-900 dark:text-white mb-2"></h4>
                    <p id="modalEventPrice" class="text-sm text-gray-600 dark:text-gray-400 mb-3"></p>
                    <a id="viewEventDetailsLink" href="#" target="_blank" class="inline-flex items-center text-sm text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300">
                        <i class="bx bx-info-circle mr-1"></i>
                        View Event Details
                    </a>
                </div>
                
                <div id="freeEventNotice" class="hidden bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-3 mb-4">
                    <p class="text-sm text-blue-800 dark:text-blue-300">
                        <i class="bx bx-info-circle mr-1"></i>
                        This is a free event. Click confirm to get your ticket.
                    </p>
                </div>
                
                <div id="paidEventNotice" class="hidden bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-3 mb-4">
                    <p class="text-sm text-yellow-800 dark:text-yellow-300">
                        <i class="bx bx-info-circle mr-1"></i>
                        Payment processing for paid events is not yet implemented. You can only register for free events.
                    </p>
                </div>
                
                <div class="flex gap-3 mt-6">
                    <button onclick="closeModal()" class="flex-1 px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                        Cancel
                    </button>
                    <button id="confirmButton" onclick="confirmRegistration()" class="flex-1 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Confirm
                    </button>
                </div>
            </div>
            
            <div id="loadingState" class="hidden text-center py-8">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-600 mx-auto mb-4"></div>
                <p class="text-sm text-gray-600 dark:text-gray-400">Processing your registration...</p>
            </div>
            
            <div id="successState" class="hidden text-center py-8">
                <div class="w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bx bx-check text-3xl text-green-600 dark:text-green-400"></i>
                </div>
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Registration Successful!</h4>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Your ticket has been confirmed.</p>
                <button onclick="goToTickets()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    View My Tickets
                </button>
            </div>
            
            <div id="errorState" class="hidden text-center py-8">
                <div class="w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="bx bx-x text-3xl text-red-600 dark:text-red-400"></i>
                </div>
                <h4 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Registration Failed</h4>
                <p id="errorMessage" class="text-sm text-gray-600 dark:text-gray-400 mb-6"></p>
                <button onclick="closeModal()" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-lg hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                    Close
                </button>
            </div>
        </div>
    </div>

    <script>
        let currentEventId = null;
        let isEventFree = true;

        function registerForEvent(eventId, eventTitle, is_free, price) {
            currentEventId = eventId;
            // Event is free if is_free flag is true OR price is 0
            isEventFree = is_free || price == 0;
            
            // Update modal content
            document.getElementById('modalEventTitle').textContent = eventTitle;
            document.getElementById('modalEventPrice').textContent = isEventFree ? 'Free Event' : `$${price}`;
            
            // Update event details link
            document.getElementById('viewEventDetailsLink').href = `/events/${eventId}`;
            
            // Show/hide notices
            if (isEventFree) {
                document.getElementById('freeEventNotice').classList.remove('hidden');
                document.getElementById('paidEventNotice').classList.add('hidden');
                document.getElementById('confirmButton').disabled = false;
                document.getElementById('confirmButton').classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                document.getElementById('freeEventNotice').classList.add('hidden');
                document.getElementById('paidEventNotice').classList.remove('hidden');
                document.getElementById('confirmButton').disabled = true;
                document.getElementById('confirmButton').classList.add('opacity-50', 'cursor-not-allowed');
            }
            
            // Reset modal states
            document.getElementById('modalContent').classList.remove('hidden');
            document.getElementById('loadingState').classList.add('hidden');
            document.getElementById('successState').classList.add('hidden');
            document.getElementById('errorState').classList.add('hidden');
            
            // Show modal
            document.getElementById('registrationModal').classList.remove('hidden');
        }

        function closeModal() {
            document.getElementById('registrationModal').classList.add('hidden');
            currentEventId = null;
        }

        async function confirmRegistration() {
            if (!currentEventId) return;
            
            // Show loading state
            document.getElementById('modalContent').classList.add('hidden');
            document.getElementById('loadingState').classList.remove('hidden');
            
            try {
                const response = await fetch('/api/tickets', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        event_id: currentEventId
                    })
                });

                const data = await response.json();

                if (response.ok) {
                    // Show success state
                    document.getElementById('loadingState').classList.add('hidden');
                    document.getElementById('successState').classList.remove('hidden');
                } else {
                    // Show error state
                    document.getElementById('loadingState').classList.add('hidden');
                    document.getElementById('errorState').classList.remove('hidden');
                    document.getElementById('errorMessage').textContent = data.message || 'Failed to register for event. Please try again.';
                }
            } catch (error) {
                console.error('Registration error:', error);
                document.getElementById('loadingState').classList.add('hidden');
                document.getElementById('errorState').classList.remove('hidden');
                document.getElementById('errorMessage').textContent = 'An error occurred. Please try again.';
            }
        }

        function goToTickets() {
            window.location.href = '{{ route("tickets.index") }}';
        }

        // Close modal on escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });

        // Close modal on backdrop click
        document.getElementById('registrationModal').addEventListener('click', function(event) {
            if (event.target === this) {
                closeModal();
            }
        });
    </script>
@endsection