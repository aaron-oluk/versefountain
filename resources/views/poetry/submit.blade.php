@extends('layouts.app')

@section('title', 'Submit New Work - VerseFountain')

@section('content')
<div class="min-h-screen bg-gray-50">
    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumbs -->
        <div class="mb-6">
            <nav class="text-sm text-gray-600">
                <a href="/" class="hover:text-gray-900">Home</a>
                <span class="mx-2">></span>
                <a href="#" class="hover:text-gray-900">Creator Studio</a>
                <span class="mx-2">></span>
                <span class="text-gray-900">Submit New Work</span>
            </nav>
        </div>

        <!-- Page Header -->
        <div class="flex items-start justify-between mb-8">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900 mb-2">Submit a New Work</h1>
                <p class="text-sm text-gray-600">Share your poetry and stories with the world.</p>
            </div>
            <a href="#" class="flex items-center text-sm text-blue-600 hover:text-blue-700">
                <i class="bx bx-help-circle text-lg mr-1"></i>
                Submission Guidelines
            </a>
        </div>

        <!-- Form Card -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-8">
            <form method="POST" action="#" class="space-y-6">
                @csrf

                <!-- Work Title -->
                <div>
                    <label for="title" class="block text-xs font-semibold text-gray-700 uppercase tracking-wide mb-2">Work Title</label>
                    <input type="text" id="title" name="title" required
                           class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                           placeholder="Enter the title of your masterpiece">
                </div>

                <!-- Author / Pen Name -->
                <div>
                    <label for="author" class="block text-sm font-medium text-gray-700 mb-2">Author / Pen Name</label>
                    <div class="relative">
                        <input type="text" id="author" name="author" value="{{ auth()->user()->username ?? '' }}" required
                               class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        <i class="bx bx-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                <!-- Genre -->
                <div>
                    <label for="genre" class="block text-sm font-medium text-gray-700 mb-2">Genre</label>
                    <div class="relative">
                        <select id="genre" name="genre" required
                                class="w-full pl-10 pr-10 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent appearance-none bg-white">
                            <option value="">Select a genre...</option>
                            <option value="poetry">Poetry</option>
                            <option value="fiction">Fiction</option>
                            <option value="non-fiction">Non-Fiction</option>
                            <option value="drama">Drama</option>
                        </select>
                        <i class="bx bx-chevron-down absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 pointer-events-none"></i>
                    </div>
                </div>

                <!-- Cover Art -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Cover Art</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-12 text-center hover:border-blue-400 transition-colors cursor-pointer">
                        <i class="bx bx-image text-5xl text-gray-400 mb-4"></i>
                        <p class="text-sm text-gray-600 mb-1">
                            <span class="text-blue-600 hover:underline">Click to upload</span> or drag and drop
                        </p>
                        <p class="text-xs text-gray-500">SVG, PNG, JPG (MAX. 800x1200px)</p>
                    </div>
                </div>

                <!-- Synopsis / Description -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Synopsis / Description</label>
                    <!-- Toolbar -->
                    <div class="border border-gray-300 rounded-t-lg bg-gray-50 p-2 flex items-center gap-2">
                        <button type="button" class="p-1.5 hover:bg-gray-200 rounded">
                            <i class="bx bx-bold text-gray-600"></i>
                        </button>
                        <button type="button" class="p-1.5 hover:bg-gray-200 rounded">
                            <i class="bx bx-italic text-gray-600"></i>
                        </button>
                        <button type="button" class="p-1.5 hover:bg-gray-200 rounded">
                            <i class="bx bx-underline text-gray-600"></i>
                        </button>
                        <div class="w-px h-6 bg-gray-300"></div>
                        <button type="button" class="p-1.5 hover:bg-gray-200 rounded">
                            <i class="bx bx-list-ul text-gray-600"></i>
                        </button>
                        <button type="button" class="p-1.5 hover:bg-gray-200 rounded">
                            <i class="bx bx-list-ol text-gray-600"></i>
                        </button>
                        <button type="button" class="p-1.5 hover:bg-gray-200 rounded">
                            <i class="bx bx-link text-gray-600"></i>
                        </button>
                    </div>
                    <textarea id="description" name="description" rows="6" required
                              class="w-full px-4 py-3 border border-t-0 border-gray-300 rounded-b-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                              placeholder="Write a compelling summary of your work here..."></textarea>
                </div>

                <!-- Upload Manuscript -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label class="block text-sm font-medium text-gray-700">Upload Manuscript</label>
                        <a href="#" class="text-sm text-blue-600 hover:text-blue-700">Download formatting template</a>
                    </div>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-12 text-center hover:border-blue-400 transition-colors cursor-pointer">
                        <i class="bx bx-cloud-upload text-5xl text-blue-600 mb-4"></i>
                        <p class="text-sm text-gray-600 mb-1">
                            <span class="text-blue-600 hover:underline">Click to upload</span> or drag and drop
                        </p>
                        <p class="text-xs text-gray-500">PDF, EPUB or DOCX (MAX. 50MB)</p>
                    </div>
                </div>

                <!-- Rights Confirmation -->
                <div class="flex items-start">
                    <input type="checkbox" id="rights" name="rights" required
                           class="h-4 w-4 text-blue-600 focus:ring-0 focus:ring-offset-0 border-gray-300 rounded mt-0.5">
                    <label for="rights" class="ml-2 block text-sm text-gray-700">
                        I confirm that I own the rights to this work.
                    </label>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-4 pt-4">
                    <button type="button" class="flex-1 px-6 py-3 bg-gray-200 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-300 transition-colors">
                        Save as Draft
                    </button>
                    <button type="submit" class="flex-1 px-6 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center">
                        Submit for Review
                        <i class="bx bx-right-arrow-alt ml-2 text-lg"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

