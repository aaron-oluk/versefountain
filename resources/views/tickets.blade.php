@extends('layouts.app')

@section('title', 'My Tickets - VerseFountain')
@section('pageTitle', 'My Tickets')

@section('content')
    <div class="max-w-7xl mx-auto px-3 sm:px-4">
        <!-- Page Header -->
        <div class="mb-4 sm:mb-6">
            <h2 class="text-xl sm:text-2xl font-semibold text-gray-900 dark:text-white mb-1">My Tickets</h2>
            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Manage your event tickets and registrations</p>
        </div>

        <!-- Tab Navigation -->
        <div class="mb-4 sm:mb-6">
            <div class="border-b border-gray-200 dark:border-gray-700 overflow-x-auto">
                <nav class="-mb-px flex space-x-4 sm:space-x-8 whitespace-nowrap">
                    <button onclick="switchTab('upcoming')" id="upcoming-tab"
                        class="tab-button border-b-2 border-blue-600 text-blue-600 dark:text-blue-400 py-3 px-1 text-xs sm:text-sm font-medium">
                        Upcoming ({{ $upcomingTickets->count() }})
                    </button>
                    <button onclick="switchTab('past')" id="past-tab"
                        class="tab-button border-b-2 border-transparent text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 hover:border-gray-300 dark:hover:border-gray-600 py-3 px-1 text-xs sm:text-sm font-medium">
                        Past ({{ $pastTickets->count() }})
                    </button>
                </nav>
            </div>
        </div>

        <!-- Upcoming Tickets Tab -->
        <div id="upcoming-content" class="tab-content">
            @if($upcomingTickets->count() > 0)
                <div class="grid grid-cols-1 gap-3 sm:gap-4">
                    @foreach($upcomingTickets as $ticket)
                        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden hover:shadow-md transition-shadow">
                            <div class="p-3 sm:p-4 md:p-5 md:p-6">
                                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                                    <!-- Date Badge -->
                                    <div class="flex-shrink-0">
                                        <div class="w-16 h-20 sm:w-20 sm:h-24 bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/30 dark:to-blue-800/20 rounded-lg flex flex-col items-center justify-center border border-blue-200 dark:border-blue-800">
                                            <span class="text-lg sm:text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $ticket->event->date->format('d') }}</span>
                                            <span class="text-xs text-blue-600 dark:text-blue-400 uppercase font-medium">{{ $ticket->event->date->format('M') }}</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $ticket->event->date->format('Y') }}</span>
                                        </div>
                                    </div>

                                    <!-- Event Details -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2 mb-2">
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-1 break-words">{{ $ticket->event->title }}</h3>
                                                <div class="flex flex-col sm:flex-row sm:flex-wrap items-start sm:items-center gap-1 sm:gap-3 text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                                                    <span class="flex items-center">
                                                        <i class="bx bx-time-five mr-1"></i>
                                                        {{ $ticket->event->date->format('g:i A') }}
                                                    </span>
                                                    @if($ticket->event->location)
                                                        <span class="flex items-center">
                                                            <i class="bx bx-map mr-1"></i>
                                                            {{ Str::limit($ticket->event->location, 30) }}
                                                        </span>
                                                    @endif
                                                    @if($ticket->event->is_virtual)
                                                        <span class="flex items-center px-2 py-0.5 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-400 rounded-full text-xs font-medium">
                                                            <i class="bx bx-video mr-1"></i>
                                                            Virtual
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <!-- Status Badge -->
                                            <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium flex-shrink-0
                                                {{ $ticket->status === 'confirmed' ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400' : '' }}
                                                {{ $ticket->status === 'pending' ? 'bg-yellow-100 dark:bg-yellow-900/30 text-yellow-700 dark:text-yellow-400' : '' }}
                                                {{ $ticket->status === 'cancelled' ? 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-400' : '' }}">
                                                <span class="w-1.5 h-1.5 rounded-full mr-1.5
                                                    {{ $ticket->status === 'confirmed' ? 'bg-green-500' : '' }}
                                                    {{ $ticket->status === 'pending' ? 'bg-yellow-500' : '' }}
                                                    {{ $ticket->status === 'cancelled' ? 'bg-red-500' : '' }}">
                                                </span>
                                                {{ ucfirst($ticket->status) }}
                                            </span>
                                        </div>

                                        @if($ticket->event->description)
                                            <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400 mb-2 sm:mb-3 line-clamp-2">{{ $ticket->event->description }}</p>
                                        @endif

                                        <!-- Ticket Info -->
                                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-2 mb-3 sm:mb-4 p-2 sm:p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                            <div class="flex items-center text-xs">
                                                <span class="text-gray-500 dark:text-gray-400 mr-1.5">Ticket #:</span>
                                                <span class="font-mono font-medium text-gray-900 dark:text-white truncate">{{ strtoupper(substr($ticket->ticketCode ?? 'N/A', 0, 8)) }}</span>
                                            </div>
                                            @if(!$ticket->event->is_free && $ticket->event->ticket_price > 0)
                                                <div class="flex items-center text-xs">
                                                    <span class="text-gray-500 dark:text-gray-400 mr-1.5">Price:</span>
                                                    <span class="font-semibold text-gray-900 dark:text-white">${{ $ticket->event->ticket_price }}</span>
                                                </div>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 rounded-full text-xs font-medium">
                                                    Free Event
                                                </span>
                                            @endif
                                            <div class="flex items-center text-xs">
                                                <span class="text-gray-500 dark:text-gray-400 mr-1.5">Category:</span>
                                                <span class="text-gray-900 dark:text-white truncate">{{ ucwords(str_replace('-', ' ', $ticket->event->category)) }}</span>
                                            </div>
                                        </div>

                                        <!-- Actions -->
                                        <div class="flex flex-col sm:flex-row flex-wrap gap-2">
                                            <a href="{{ route('events.show', $ticket->event->uuid) }}"
                                                class="inline-flex items-center justify-center sm:justify-start px-3 sm:px-4 py-2 bg-blue-600 text-white text-xs sm:text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                                <i class="bx bx-info-circle mr-1.5 text-sm"></i>
                                                View Event Details
                                            </a>
                                            @if($ticket->event->is_virtual && $ticket->event->stream_url && $ticket->status === 'confirmed')
                                                <a href="{{ $ticket->event->stream_url }}" target="_blank"
                                                    class="inline-flex items-center justify-center sm:justify-start px-3 sm:px-4 py-2 bg-purple-600 text-white text-xs sm:text-sm font-medium rounded-lg hover:bg-purple-700 transition-colors">
                                                    <i class="bx bx-video mr-1.5 text-sm"></i>
                                                    Join Virtual
                                                </a>
                                            @endif
                                            @if($ticket->status === 'confirmed')
                                                <button onclick="cancelTicket('{{ $ticket->id }}')"
                                                    class="inline-flex items-center justify-center sm:justify-start px-3 sm:px-4 py-2 bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 text-xs sm:text-sm font-medium rounded-lg hover:bg-gray-200 dark:hover:bg-gray-700 transition-colors">
                                                    <i class="bx bx-x mr-1.5 text-sm"></i>
                                                    Cancel
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-6 sm:p-8 md:p-12 text-center">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                        <i class="bx bx-ticket text-2xl sm:text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-1 sm:mb-2">No Upcoming Tickets</h3>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-4 sm:mb-6">You don't have any tickets for upcoming events yet.</p>
                    <a href="{{ route('events.index') }}"
                        class="inline-flex items-center px-4 sm:px-6 py-2 sm:py-2.5 bg-blue-600 text-white text-xs sm:text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                        <i class="bx bx-calendar-event mr-2"></i>
                        Browse Events
                    </a>
                </div>
            @endif
        </div>

        <!-- Past Tickets Tab -->
        <div id="past-content" class="tab-content hidden">
            @if($pastTickets->count() > 0)
                <div class="grid grid-cols-1 gap-3 sm:gap-4">
                    @foreach($pastTickets as $ticket)
                        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden opacity-75">
                            <div class="p-3 sm:p-4 md:p-5 md:p-6">
                                <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                                    <!-- Date Badge -->
                                    <div class="flex-shrink-0">
                                        <div class="w-16 h-20 sm:w-20 sm:h-24 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-lg flex flex-col items-center justify-center border border-gray-200 dark:border-gray-700">
                                            <span class="text-lg sm:text-2xl font-bold text-gray-600 dark:text-gray-400">{{ $ticket->event->date->format('d') }}</span>
                                            <span class="text-xs text-gray-600 dark:text-gray-400 uppercase font-medium">{{ $ticket->event->date->format('M') }}</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">{{ $ticket->event->date->format('Y') }}</span>
                                        </div>
                                    </div>

                                    <!-- Event Details -->
                                    <div class="flex-1 min-w-0">
                                        <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-2 mb-2">
                                            <div class="flex-1 min-w-0">
                                                <h3 class="text-base sm:text-lg font-semibold text-gray-700 dark:text-gray-300 mb-1 break-words">{{ $ticket->event->title }}</h3>
                                                <div class="flex flex-col sm:flex-row sm:flex-wrap items-start sm:items-center gap-1 sm:gap-3 text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                                                    <span class="flex items-center">
                                                        <i class="bx bx-time-five mr-1"></i>
                                                        {{ $ticket->event->date->format('g:i A') }}
                                                    </span>
                                                    @if($ticket->event->location)
                                                        <span class="flex items-center">
                                                            <i class="bx bx-map mr-1"></i>
                                                            {{ Str::limit($ticket->event->location, 30) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            <span class="inline-flex items-center px-2.5 py-1 bg-gray-100 dark:bg-gray-800 text-gray-600 dark:text-gray-400 rounded-full text-xs font-medium flex-shrink-0">
                                                Attended
                                            </span>
                                        </div>

                                        <!-- Ticket Info -->
                                        <div class="flex items-center gap-2 mt-2 sm:mt-3 p-2 sm:p-3 bg-gray-50 dark:bg-gray-800 rounded-lg">
                                            <div class="flex items-center text-xs">
                                                <span class="text-gray-500 dark:text-gray-400 mr-1.5">Ticket #:</span>
                                                <span class="font-mono font-medium text-gray-700 dark:text-gray-300 truncate">{{ strtoupper(substr($ticket->ticketCode ?? 'N/A', 0, 8)) }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-6 sm:p-8 md:p-12 text-center">
                    <div class="w-12 h-12 sm:w-16 sm:h-16 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                        <i class="bx bx-history text-2xl sm:text-3xl text-gray-400"></i>
                    </div>
                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-1 sm:mb-2">No Past Tickets</h3>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">You haven't attended any events yet.</p>
                </div>
            @endif
        </div>
    </div>

    <script>
        function switchTab(tab) {
            // Update tab buttons
            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('border-blue-600', 'text-blue-600', 'dark:text-blue-400');
                btn.classList.add('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            });
            
            document.getElementById(tab + '-tab').classList.remove('border-transparent', 'text-gray-500', 'dark:text-gray-400');
            document.getElementById(tab + '-tab').classList.add('border-blue-600', 'text-blue-600', 'dark:text-blue-400');
            
            // Update content
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            document.getElementById(tab + '-content').classList.remove('hidden');
        }

        async function cancelTicket(ticketId) {
            if (!confirm('Are you sure you want to cancel this ticket? This action cannot be undone.')) {
                return;
            }

            try {
                const response = await fetch(`/api/tickets/${ticketId}/cancel`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    }
                });

                const data = await response.json();

                if (response.ok) {
                    alert('Ticket cancelled successfully');
                    window.location.reload();
                } else {
                    alert(data.message || 'Failed to cancel ticket');
                }
            } catch (error) {
                console.error('Error cancelling ticket:', error);
                alert('An error occurred while cancelling the ticket');
            }
        }
    </script>
@endsection