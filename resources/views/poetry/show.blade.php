@extends('layouts.app')

@section('title', ($poem->title ?? 'Poem') . ' - VerseFountain')

@section('content')
    <div class="min-h-screen bg-stone-50 dark:bg-gray-900" id="poetry-show-container">
        <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('poetry.index') }}"
                    class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm font-normal">
                    <i class="bx bx-arrow-back text-base mr-1"></i>
                    Back to poems
                </a>
            </div>

            <div class="max-w-4xl mx-auto">
                <!-- Server-side Flash Messages -->
                @if (session('success'))
                    <div
                        class="mb-4 p-4 bg-blue-50 border border-blue-200 text-blue-800 rounded-md flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <i class="bx bx-check-circle text-lg"></i>
                            <span class="text-sm font-normal">{{ session('success') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="ml-4 text-blue-600 hover:text-blue-800">
                            <i class="bx bx-x text-lg"></i>
                        </button>
                    </div>
                @endif

                @if (session('error'))
                    <div
                        class="mb-4 p-4 bg-red-50 border border-red-200 text-red-800 rounded-md flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <i class="bx bx-error-circle text-lg"></i>
                            <span class="text-sm font-normal">{{ session('error') }}</span>
                        </div>
                        <button onclick="this.parentElement.remove()" class="ml-4 text-red-600 hover:text-red-800">
                            <i class="bx bx-x text-lg"></i>
                        </button>
                    </div>
                @endif

                <div class="bg-white dark:bg-gray-800 shadow-sm rounded-md" data-poem-detail
                    data-poem-id="{{ $poem->id }}" data-is-liked="{{ $isLiked ? 'true' : 'false' }}"
                    data-likes-count="{{ $poem->userInteractions->where('liked', true)->count() ?? 0 }}"
                    data-current-rating="{{ $userRating ?? 0 }}"
                    data-avg-rating="{{ number_format($poem->userInteractions->whereNotNull('rating')->avg('rating') ?? 0, 1) }}"
                    data-rating-count="{{ $poem->userInteractions->whereNotNull('rating')->count() }}"
                    data-is-authenticated="{{ auth()->check() ? 'true' : 'false' }}"
                    data-poem-title="{{ addslashes($poem->title ?? '') }}"
                    data-poem-content="{{ addslashes(Str::limit($poem->content ?? '', 200)) }}"
                    data-poetry-index-url="{{ route('poetry.index') }}">

                    <!-- Header -->
                    <div class="p-6 sm:p-8 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h1
                                    class="text-2xl md:text-3xl font-light text-gray-800 dark:text-white mb-3 tracking-wide">
                                    {{ $poem->title ?? 'Untitled' }}</h1>
                                <div class="flex items-center space-x-4 text-gray-600 dark:text-gray-400">
                                    <div class="flex items-center space-x-2">
                                        <div class="h-8 w-8 rounded-full bg-gray-100 flex items-center justify-center">
                                            <span class="text-xs font-normal text-gray-700">
                                                {{ strtoupper(($poem->author->first_name ?? 'A')[0]) }}
                                            </span>
                                        </div>
                                        <span
                                            class="text-sm font-light">{{ $poem->author->first_name ?? 'Anonymous' }}</span>
                                    </div>
                                    <span class="text-gray-400">•</span>
                                    <span
                                        class="text-sm text-gray-500">{{ $poem->created_at->diffForHumans() ?? '' }}</span>
                                </div>
                            </div>

                            @auth
                                @if (Auth::id() === $poem->author_id)
                                    <div class="flex space-x-2">
                                        <a href="{{ route('poetry.edit', $poem) }}"
                                            class="inline-flex items-center px-3 py-2 shadow-sm text-sm font-normal text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                            Edit
                                        </a>
                                        <button data-delete-poem
                                            class="inline-flex items-center px-3 py-2 shadow-sm text-sm font-normal text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                            Delete
                                        </button>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>

                    <!-- Content -->
                    <div class="p-6 sm:p-8">
                        @if ($poem->is_video && $poem->video_url)
                            <div class="mb-8">
                                <div class="aspect-video bg-gray-100 overflow-hidden">
                                    <iframe src="{{ $poem->video_url }}" class="w-full h-full" allowfullscreen
                                        title="{{ $poem->title ?? 'Poem Video' }}">
                                    </iframe>
                                </div>
                            </div>
                        @endif

                        <div class="prose prose-lg max-w-none">
                            <div class="whitespace-pre-line text-gray-700 dark:text-gray-300 leading-relaxed font-light">
                                {{ $poem->content ?? '' }}
                            </div>
                        </div>
                    </div>

                    <!-- Engagement Section -->
                    <div class="px-6 sm:px-8 py-4 border-t border-gray-200 bg-gray-50 dark:bg-gray-900">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-6 text-gray-700 dark:text-gray-300">
                                <!-- Like Button -->
                                <button data-like-button
                                    class="flex items-center space-x-2 text-sm font-normal transition-colors {{ $isLiked ? 'text-red-500' : 'text-gray-600 dark:text-gray-400 hover:text-red-500' }}">
                                    <i class="{{ $isLiked ? 'bx bxs-heart' : 'bx bx-heart' }} text-base"></i>
                                    <span
                                        data-likes-count>{{ $poem->userInteractions->where('liked', true)->count() ?? 0 }}</span>
                                </button>

                                <!-- Comment Button -->
                                <button data-comments-toggle
                                    class="flex items-center space-x-2 text-gray-600 hover:text-gray-900 text-sm font-normal transition-colors">
                                    <i class="bx bx-comment text-base"></i>
                                    <span>{{ $poem->comments->count() ?? 0 }} Comments</span>
                                </button>

                                <!-- Rating -->
                                <div class="flex items-center space-x-1">
                                    @php
                                        $userRatingFromController = $userRating ?? 0;
                                    @endphp
                                    @for ($i = 1; $i <= 5; $i++)
                                        <button data-rating="{{ $i }}"
                                            class="transition-colors cursor-pointer {{ $userRatingFromController >= $i ? 'text-yellow-500' : 'text-gray-400 hover:text-yellow-400' }}">
                                            <i
                                                class="{{ $userRatingFromController >= $i ? 'bx bxs-star' : 'bx bx-star' }} text-base"></i>
                                        </button>
                                    @endfor
                                    @php
                                        $ratingAvg =
                                            $poem->userInteractions->whereNotNull('rating')->avg('rating') ?? 0;
                                        $ratingCount = $poem->userInteractions->whereNotNull('rating')->count();
                                    @endphp
                                    <span class="text-xs text-gray-500 dark:text-gray-400 ml-2" data-rating-display>
                                        {{ number_format($ratingAvg, 1) }} ({{ $ratingCount }})
                                    </span>
                                </div>
                            </div>

                            <!-- Share Button with Dropdown -->
                            <div class="relative">
                                <button data-share-toggle
                                    class="flex items-center space-x-2 text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white text-sm font-normal transition-colors">
                                    <i class="bx bx-share-alt text-base"></i>
                                    <span>Share</span>
                                </button>

                                <!-- Share Menu Dropdown -->
                                <div data-share-menu
                                    class="absolute right-0 mt-2 w-56 bg-white dark:bg-gray-800 shadow-sm rounded-md py-2 z-50 hidden border border-gray-100 dark:border-gray-700">
                                    <button data-share-copy
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 flex items-center space-x-2">
                                        <i class="bx bx-link text-base"></i>
                                        <span>Copy Link</span>
                                    </button>
                                    <button data-share-twitter
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 flex items-center space-x-2">
                                        <i class="bx bxl-twitter text-base text-blue-400"></i>
                                        <span>Share on Twitter</span>
                                    </button>
                                    <button data-share-facebook
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 flex items-center space-x-2">
                                        <i class="bx bxl-facebook text-base text-blue-600"></i>
                                        <span>Share on Facebook</span>
                                    </button>
                                    <button data-share-whatsapp
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 flex items-center space-x-2">
                                        <i class="bx bxl-whatsapp text-base text-blue-500"></i>
                                        <span>Share on WhatsApp</span>
                                    </button>
                                    <button data-share-email
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 flex items-center space-x-2">
                                        <i class="bx bx-envelope text-base"></i>
                                        <span>Share via Email</span>
                                    </button>
                                    <div class="border-t border-gray-200 my-1"></div>
                                    <button data-share-native
                                        class="w-full text-left px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-700 flex items-center space-x-2">
                                        <i class="bx bx-share text-base"></i>
                                        <span>More Options...</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Comments Section -->
                    <div class="border-t border-gray-200 dark:border-gray-700">

                        <!-- Comment Form (Initially Hidden) -->
                        @auth
                            <div data-comment-form-container class="p-6 border-b border-gray-200 dark:border-gray-700 hidden">
                                <form data-comment-form>
                                    <div class="flex space-x-3">
                                        <div
                                            class="h-8 w-8 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center flex-shrink-0">
                                            <span class="text-xs font-normal text-gray-700 dark:text-gray-300">
                                                {{ strtoupper((Auth::user()->first_name ?? 'U')[0]) }}
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <textarea name="content" placeholder="Write a comment..."
                                                class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:border-blue-600 dark:focus:border-blue-500 focus:outline-none resize-none text-sm rounded-md"
                                                rows="3" required></textarea>
                                            <div class="mt-2 flex justify-end">
                                                <button type="submit"
                                                    class="px-4 py-2 bg-blue-600 dark:bg-blue-700 text-white text-sm font-normal hover:bg-blue-700 dark:hover:bg-blue-600 transition-colors disabled:opacity-50 disabled:cursor-not-allowed rounded-md">
                                                    Comment
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @endauth

                        <!-- Comments List (Always Visible) -->
                        <div class="p-6">
                            <h3 class="text-lg font-light text-gray-800 dark:text-white mb-4 tracking-wide">Comments
                                ({{ $poem->comments->count() ?? 0 }})</h3>

                            <div class="space-y-4">
                                @forelse($poem->comments ?? [] as $comment)
                                    <div class="flex space-x-3">
                                        <div
                                            class="h-8 w-8 rounded-full bg-gray-100 dark:bg-gray-700 flex items-center justify-center flex-shrink-0">
                                            <span class="text-xs font-normal text-gray-700 dark:text-gray-300">
                                                {{ strtoupper(($comment->user->first_name ?? 'U')[0]) }}
                                            </span>
                                        </div>
                                        <div class="flex-1">
                                            <div class="bg-gray-50 dark:bg-gray-700 px-4 py-3 rounded-md">
                                                <div class="flex items-center justify-between mb-1">
                                                    <span
                                                        class="text-sm font-normal text-gray-900 dark:text-white">{{ $comment->user->first_name ?? 'Anonymous' }}</span>
                                                    <span
                                                        class="text-xs text-gray-500 dark:text-gray-400">{{ $comment->created_at->diffForHumans() ?? '' }}</span>
                                                </div>
                                                <p class="text-sm text-gray-700 dark:text-gray-300 font-light">
                                                    {{ $comment->content ?? '' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <p class="text-gray-500 dark:text-gray-400 text-center py-4 font-light">No comments
                                        yet. Be the first to comment!</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
