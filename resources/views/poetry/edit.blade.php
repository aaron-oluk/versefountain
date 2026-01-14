@extends('layouts.app')

@section('title', 'Edit Poem - VerseFountain')

@section('content')
<div class="min-h-screen bg-stone-50 dark:bg-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ route('poetry.show', $poem) }}" 
               class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm font-normal">
                <i class="bx bx-arrow-back text-base mr-1"></i>
                Back to poem
            </a>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="mb-8">
                <h1 class="text-2xl sm:text-3xl font-light text-gray-900 dark:text-white mb-2 tracking-wide">Edit Poem</h1>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Update your poetry</p>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-md shadow-sm p-6 sm:p-8">
                <form method="POST" action="{{ route('poetry.update', $poem) }}" id="poem-edit-form" data-poem-form>
                    @csrf
                    @method('PUT')

                    <div class="space-y-6">
                        <!-- Title -->
                        <div>
                            <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Title</label>
                            <input id="title" name="title" type="text"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md focus:border-blue-600 dark:focus:border-blue-500 focus:outline-none"
                                value="{{ old('title', $poem->title) }}" required autofocus />
                            @error('title')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Poem Type Toggle -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Poem Type</label>
                            <div class="mt-2 flex space-x-4">
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="is_video" value="0" {{ !$poem->is_video ? 'checked' : '' }}
                                        class="h-4 w-4 text-blue-600 dark:text-blue-500 focus:ring-blue-500 border-gray-300 dark:border-gray-600">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Text Poem</span>
                                </label>
                                <label class="flex items-center cursor-pointer">
                                    <input type="radio" name="is_video" value="1" {{ $poem->is_video ? 'checked' : '' }}
                                        class="h-4 w-4 text-blue-600 dark:text-blue-500 focus:ring-blue-500 border-gray-300 dark:border-gray-600">
                                    <span class="ml-2 text-sm text-gray-700 dark:text-gray-300">Video Poem</span>
                                </label>
                            </div>
                        </div>

                        <!-- Video URL (conditional) -->
                        <div id="video-url-section" style="display: {{ $poem->is_video ? 'block' : 'none' }};">
                            <label for="video_url" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Video URL</label>
                            <input id="video_url" name="video_url" type="url"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white rounded-md focus:border-blue-600 dark:focus:border-blue-500 focus:outline-none"
                                value="{{ old('video_url', $poem->video_url) }}" />
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                                Enter the embed URL from YouTube or other video platforms
                            </p>
                            @error('video_url')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Content -->
                        <div>
                            <label for="content" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Content</label>
                            <textarea id="content" name="content" rows="12" required
                                class="mt-1 block w-full border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-blue-600 dark:focus:border-blue-500 focus:outline-none rounded-md resize-none transition-colors"
                                placeholder="{{ $poem->is_video ? 'Describe your video poem...' : 'Write your poem here...' }}">{{ old('content', $poem->content) }}</textarea>
                            <div class="mt-2 flex justify-between items-center text-sm text-gray-500 dark:text-gray-400">
                                <span data-content-length>{{ strlen(old('content', $poem->content)) }}</span>
                                <span>Maximum 10,000 characters</span>
                            </div>
                            @error('content')
                                <p class="mt-2 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Preview -->
                        <div id="preview-section" data-preview-section style="display: none;">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Preview</label>
                            <div class="mt-2 bg-gray-50 dark:bg-gray-700 rounded-md p-4 shadow-sm border border-gray-200 dark:border-gray-600">
                                <h3 class="font-light text-lg text-gray-900 dark:text-white mb-2" data-preview-title>Untitled</h3>
                                <div class="prose prose-sm max-w-none">
                                    <p class="whitespace-pre-line text-gray-700 dark:text-gray-300" data-preview-content>No content yet</p>
                                </div>
                            </div>
                        </div>

                        <!-- Form Actions -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                            <div class="flex space-x-3">
                                <button type="button" data-preview-toggle
                                    class="inline-flex items-center px-4 py-2 shadow-sm text-sm font-normal rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none transition-colors">
                                    <span>Show Preview</span>
                                </button>
                            </div>

                            <div class="flex space-x-3">
                                <a href="{{ route('poetry.show', $poem) }}"
                                    class="inline-flex items-center px-4 py-2 shadow-sm text-sm font-normal rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none transition-colors">
                                    Cancel
                                </a>
                                <button type="submit"
                                    class="inline-flex items-center px-4 py-2 bg-blue-600 dark:bg-blue-700 rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 dark:hover:bg-blue-600 focus:bg-blue-700 dark:focus:bg-blue-600 active:bg-blue-800 dark:active:bg-blue-800 focus:outline-none transition ease-in-out duration-150">
                                    <span>Update Poem</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('poem-edit-form');
            if (!form) return;

            // Initialize PoemForm
            const poemForm = new PoemForm(form);

            // Handle video type toggle
            const videoRadios = form.querySelectorAll('input[name="is_video"]');
            const videoUrlSection = document.getElementById('video-url-section');
            const contentTextarea = form.querySelector('#content');

            videoRadios.forEach(radio => {
                radio.addEventListener('change', function () {
                    if (this.value === '1') {
                        videoUrlSection.style.display = 'block';
                        if (contentTextarea) {
                            contentTextarea.placeholder = 'Describe your video poem...';
                        }
                    } else {
                        videoUrlSection.style.display = 'none';
                        if (contentTextarea) {
                            contentTextarea.placeholder = 'Write your poem here...';
                        }
                    }
                });
            });
        });
    </script>
@endsection