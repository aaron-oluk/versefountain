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
                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Event Name <span class="text-red-500">*</span>
                        </label>
                        <input id="name" 
                               name="name" 
                               type="text" 
                               required
                               placeholder="Enter event name"
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

                    <!-- Price & Capacity -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Price (USD)
                            </label>
                            <input id="price" 
                                   name="price" 
                                   type="number" 
                                   min="0" 
                                   step="0.01"
                                   placeholder="0.00"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Leave blank for free events</p>
                        </div>
                        <div>
                            <label for="capacity" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Max Capacity
                            </label>
                            <input id="capacity" 
                                   name="capacity" 
                                   type="number" 
                                   min="1"
                                   placeholder="Unlimited"
                                   class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                        </div>
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

    // Form handler
    const formHandler = new CRUDFormHandler(form, {
        async onSubmit(formData) {
            // Convert price to decimal if present
            if (formData.price) {
                formData.price = parseFloat(formData.price);
            }
            
            // Combine date and time if both present
            if (formData.date && formData.time) {
                formData.date = `${formData.date} ${formData.time}`;
            }
            delete formData.time;

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
