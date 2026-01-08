@extends('layouts.app')

@section('title', 'Create Event - VerseFountain')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 sm:mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">Create Event</h1>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Organize a literary event</p>
                </div>
                <a href="{{ route('events.index') }}" 
                   class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm">
                    <i class="bx bx-arrow-back text-base mr-1"></i>
                    Back
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-md shadow-sm p-4 sm:p-6">
            <form id="event-create-form" data-event-form>
                <div class="space-y-6">
                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Event Title <span class="text-red-500">*</span>
                        </label>
                        <input id="title" 
                               name="title" 
                               type="text" 
                               required
                               placeholder="Enter event title"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                    </div>

                    <!-- Date & Time -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Date <span class="text-red-500">*</span>
                            </label>
                            <input id="date" 
                                   name="date" 
                                   type="date" 
                                   required
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                        <div>
                            <label for="time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Time
                            </label>
                            <input id="time" 
                                   name="time" 
                                   type="time"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                        </div>
                    </div>

                    <!-- Location -->
                    <div>
                        <label for="location" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Location <span class="text-red-500">*</span>
                        </label>
                        <input id="location" 
                               name="location" 
                               type="text" 
                               required
                               placeholder="Enter event location or 'Online'"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Category <span class="text-red-500">*</span>
                        </label>
                        <select id="category" 
                                name="category" 
                                required
                                class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white">
                            <option value="">Select a category</option>
                            <option value="poetry">Poetry Reading</option>
                            <option value="workshop">Workshop</option>
                            <option value="book_club">Book Club</option>
                            <option value="seminar">Seminar</option>
                            <option value="other">Other</option>
                        </select>
                    </div>

                    <!-- Price & Virtual Event -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="ticketPrice" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Ticket Price (USD)
                            </label>
                            <input id="ticketPrice" 
                                   name="ticketPrice" 
                                   type="number" 
                                   min="0" 
                                   step="1"
                                   placeholder="0"
                                   value="0"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Leave as 0 for free events</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Event Type
                            </label>
                            <div class="flex items-center space-x-6">
                                <label class="flex items-center">
                                    <input type="radio" name="isVirtual" value="0" checked class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">In-Person</span>
                                </label>
                                <label class="flex items-center">
                                    <input type="radio" name="isVirtual" value="1" class="w-4 h-4 text-blue-600 focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Virtual</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Stream URL (conditional) -->
                    <div id="streamUrlContainer" class="hidden">
                        <label for="streamUrl" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Stream URL <span class="text-red-500">*</span>
                        </label>
                        <input id="streamUrl" 
                               name="streamUrl" 
                               type="url" 
                               placeholder="https://..."
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                    </div>

                    <!-- Organizer -->
                    <div>
                        <label for="organizer" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Organizer
                        </label>
                        <input id="organizer" 
                               name="organizer" 
                               type="text" 
                               placeholder="Event organizer name"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Description
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="6"
                                  placeholder="Describe your event..."
                                  class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"></textarea>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end space-x-3 pt-4">
                        <a href="{{ route('events.index') }}"
                            class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                            Cancel
                        </a>
                        <button type="submit"
                            class="px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                            Create Event
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('event-create-form');
    const eventManager = new EventManager();
    
    // Toggle stream URL field based on event type
    const isVirtualRadios = document.querySelectorAll('input[name="isVirtual"]');
    const streamUrlContainer = document.getElementById('streamUrlContainer');
    const streamUrlInput = document.getElementById('streamUrl');
    const locationInput = document.getElementById('location');
    
    isVirtualRadios.forEach(radio => {
        radio.addEventListener('change', function() {
            if (this.value === '1') {
                streamUrlContainer.classList.remove('hidden');
                streamUrlInput.required = true;
                locationInput.required = false;
            } else {
                streamUrlContainer.classList.add('hidden');
                streamUrlInput.required = false;
                streamUrlInput.value = '';
                locationInput.required = true;
            }
        });
    });

    // Form handler
    const formHandler = new CRUDFormHandler(form, {
        async onSubmit(formData) {
            // Convert ticketPrice to integer
            formData.ticketPrice = formData.ticketPrice ? parseInt(formData.ticketPrice) : 0;
            
            // Convert isVirtual to boolean
            formData.isVirtual = formData.isVirtual === '1';
            
            // Set isFree based on ticketPrice
            formData.isFree = formData.ticketPrice === 0;
            
            // Combine date and time if both present
            if (formData.date && formData.time) {
                formData.date = `${formData.date} ${formData.time}`;
            }
            delete formData.time;

            // Remove streamUrl if event is not virtual
            if (!formData.isVirtual && formData.streamUrl) {
                delete formData.streamUrl;
            }

            // Create event
            const event = await eventManager.create(formData);
            return event;
        },
        onSuccess(event) {
            if (event) {
                setTimeout(() => {
                    window.location.href = '/events';
                }, 1500);
            }
        },
        onError(error) {
            console.error('Event creation error:', error);
        }
    });
});
</script>
@endsection
