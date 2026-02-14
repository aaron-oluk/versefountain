@extends('layouts.app')

@section('title', $event->title . ' - VerseFountain')
@section('pageTitle', $event->title)

@section('content')
    <div class="max-w-6xl mx-auto px-3 sm:px-4 py-4 sm:py-8">
        <div class="mb-4 sm:mb-6">
            <a href="{{ route('events.index') }}" class="inline-flex items-center text-xs sm:text-sm font-medium text-gray-500 hover:text-blue-600">
                <i class="bx bx-arrow-back mr-1"></i> Back to Events
            </a>
        </div>

        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-sm overflow-hidden mb-6 sm:mb-8">
            <div class="p-4 sm:p-6 md:p-8 lg:p-10 grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 md:gap-10">
                <div class="flex flex-col gap-4 sm:gap-6">
                    <div class="flex flex-wrap items-center gap-2 sm:gap-3">
                        <span class="inline-flex items-center px-2.5 sm:px-3 py-1 rounded-full text-xs font-semibold bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-300 border border-gray-200 dark:border-gray-700">
                            <i class="bx bx-category text-xs sm:text-sm mr-1"></i> {{ ucwords(str_replace('_', ' ', $event->category)) }}
                        </span>
                        @if($event->is_free || $event->ticket_price == 0)
                            <span class="inline-flex items-center px-2.5 sm:px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                                <i class="bx bx-gift text-xs sm:text-sm mr-1"></i> Free Event
                            </span>
                        @endif
                        @if($event->is_virtual)
                            <span class="inline-flex items-center px-2.5 sm:px-3 py-1 rounded-full text-xs font-semibold bg-blue-50 text-blue-700 dark:bg-blue-900/20 dark:text-blue-300 border border-blue-200 dark:border-blue-800">
                                <i class="bx bx-video text-xs sm:text-sm mr-1"></i> Virtual Event
                            </span>
                        @endif
                    </div>

                    <div>
                        <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white leading-tight mb-2">{{ $event->title }}</h1>
                    </div>

                    <div class="space-y-3 sm:space-y-4">
                        <div class="flex items-start gap-3 sm:gap-4">
                            <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-400 flex-shrink-0">
                                <i class="bx bx-calendar text-sm sm:text-base"></i>
                            </div>
                            <div class="min-w-0">
                                <div class="text-xs uppercase tracking-wide font-semibold text-gray-500 dark:text-gray-400">Date & Time</div>
                                <div class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">{{ $event->date->format('F j, Y') }}</div>
                                <div class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">{{ $event->date->format('g:i A') }}</div>
                            </div>
                        </div>

                        @if(!$event->is_virtual && $event->location)
                        <div class="flex items-start gap-3 sm:gap-4">
                            <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-400 flex-shrink-0">
                                <i class="bx bx-map text-sm sm:text-base"></i>
                            </div>
                            <div class="min-w-0">
                                <div class="text-xs uppercase tracking-wide font-semibold text-gray-500 dark:text-gray-400">Location</div>
                                <div class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white break-words">{{ $event->location }}</div>
                                <a href="#" class="text-xs sm:text-sm text-blue-600 hover:underline">View on map</a>
                            </div>
                        </div>
                        @endif

                        @if($event->organizer)
                        <div class="flex items-start gap-3 sm:gap-4">
                            <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-gray-100 dark:bg-gray-800 flex items-center justify-center text-gray-600 dark:text-gray-400 flex-shrink-0">
                                <i class="bx bx-user text-sm sm:text-base"></i>
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="text-xs uppercase tracking-wide font-semibold text-gray-500 dark:text-gray-400">Organizer</div>
                                <div class="flex items-center gap-2 sm:gap-3 mt-1">
                                    <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-blue-600 text-white text-xs sm:text-sm font-bold flex items-center justify-center ring-2 ring-white dark:ring-gray-800 flex-shrink-0">{{ strtoupper(substr($event->organizer,0,1)) }}</div>
                                    <p class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white break-words">{{ $event->organizer }}</p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>

                    <div class="pt-2 sm:pt-4">
                        @auth
                            @if($hasTicket)
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 p-3 sm:p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                                    <div class="flex items-center gap-2 text-green-800 dark:text-green-200">
                                        <i class="bx bx-check-circle text-lg sm:text-xl flex-shrink-0"></i>
                                        <div>
                                            <div class="text-sm sm:text-base font-semibold">You're registered</div>
                                            <div class="text-xs sm:text-sm">Ticket is confirmed</div>
                                        </div>
                                    </div>
                                    <a href="{{ route('tickets.index') }}" class="px-3 sm:px-4 py-2 bg-green-600 text-white text-xs sm:text-sm font-medium rounded-lg hover:bg-green-700 transition-colors text-center">View Ticket</a>
                                </div>
                            @else
                                <button onclick="registerForEvent('{{ $event->uuid }}', '{{ addslashes($event->title) }}', {{ ($event->is_free || $event->ticket_price == 0) ? 'true' : 'false' }}, {{ $event->ticket_price ?? 0 }})"
                                    class="w-full sm:w-auto inline-flex items-center justify-center px-4 sm:px-5 py-2.5 sm:py-3 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-blue-700 transition-colors">
                                    <i class="bx bx-calendar-plus mr-2"></i>
                                    Register for Event
                                </button>
                            @endif
                        @else
                            <a href="{{ route('login') }}" class="w-full sm:w-auto inline-flex items-center justify-center px-4 sm:px-5 py-2.5 sm:py-3 bg-blue-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-blue-700 transition-colors">
                                <i class="bx bx-log-in mr-2"></i>
                                Login to Register
                            </a>
                        @endauth
                    </div>
                </div>

                <div class="w-full">
                    <div class="aspect-[4/3] rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-gray-800 flex items-center justify-center relative">
                        <div class="absolute inset-0 bg-gradient-to-t from-gray-200/60 to-transparent"></div>
                        <div class="text-center z-10 px-4">
                            <p class="text-base sm:text-lg font-semibold text-gray-700 dark:text-gray-200 tracking-wide">Event Cover</p>
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Add an image to make this event stand out</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @if($event->description)
        <div class="bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl shadow-sm p-4 sm:p-6 md:p-8">
            <div class="flex items-center gap-2 mb-4 text-gray-700 dark:text-gray-300">
                <i class="bx bx-info-circle text-lg sm:text-xl"></i>
                <h2 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">About This Event</h2>
            </div>
            <div class="prose prose-sm dark:prose-invert max-w-none text-xs sm:text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                {!! nl2br(e($event->description)) !!}
            </div>
        </div>
        @endif

        @if($event->is_virtual && $event->stream_url && $hasTicket)
            <div class="mt-6 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-2xl p-4 sm:p-6 md:p-8">
                <h3 class="text-base sm:text-lg font-semibold text-blue-900 dark:text-blue-200 mb-2 sm:mb-3">Join Virtual Event</h3>
                <p class="text-xs sm:text-sm text-blue-700 dark:text-blue-300 mb-4">Use the link below to join when the event starts.</p>
                <a href="{{ $event->stream_url }}" target="_blank" class="inline-flex items-center px-4 sm:px-5 py-2 sm:py-3 bg-blue-600 text-white text-xs sm:text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="bx bx-video mr-2"></i> Join Stream
                </a>
            </div>
        @endif
    </div>

    @auth
        <!-- Include the registration modal from events/index.blade.php -->
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
                        <p id="modalEventPrice" class="text-sm text-gray-600 dark:text-gray-400"></p>
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
                    <button onclick="window.location.reload()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Done
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
                isEventFree = is_free || price == 0;
                
                document.getElementById('modalEventTitle').textContent = eventTitle;
                document.getElementById('modalEventPrice').textContent = isEventFree ? 'Free Event' : `$${price}`;
                
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
                
                document.getElementById('modalContent').classList.remove('hidden');
                document.getElementById('loadingState').classList.add('hidden');
                document.getElementById('successState').classList.add('hidden');
                document.getElementById('errorState').classList.add('hidden');
                
                document.getElementById('registrationModal').classList.remove('hidden');
            }

            function closeModal() {
                document.getElementById('registrationModal').classList.add('hidden');
                currentEventId = null;
            }

            async function confirmRegistration() {
                if (!currentEventId) return;
                
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
                        document.getElementById('loadingState').classList.add('hidden');
                        document.getElementById('successState').classList.remove('hidden');
                    } else {
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

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape') {
                    closeModal();
                }
            });

            document.getElementById('registrationModal')?.addEventListener('click', function(event) {
                if (event.target === this) {
                    closeModal();
                }
            });
        </script>
    @endauth
@endsection
