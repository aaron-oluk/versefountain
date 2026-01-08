@extends('layouts.app')

@section('title', 'Poetry - VerseFountain')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-semibold text-gray-900 dark:text-white mb-1">Poetry</h2>
                <p class="text-sm text-gray-500 dark:text-gray-400">Discover beautiful poems from classic and contemporary poets</p>
            </div>
            @auth
                <a href="{{ route('poetry.create') }}"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="bx bx-pen text-lg"></i>
                    Write a Poem
                </a>
            @endauth
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm p-5 mb-6 border border-gray-100 dark:border-gray-800">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <!-- Search -->
            <div class="sm:col-span-2 lg:col-span-2">
                <label for="search" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5 uppercase tracking-wide">Search</label>
                <div class="relative">
                    <input type="text" id="search" placeholder="Search by title, author, or content..."
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-200 dark:border-gray-700 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none text-sm bg-white dark:bg-gray-800 dark:text-white">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="bx bx-search text-lg text-gray-400"></i>
                    </div>
                </div>
            </div>

            <!-- Category Filter -->
            <div>
                <label for="category" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5 uppercase tracking-wide">Category</label>
                <select id="category"
                    class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none text-sm bg-white dark:bg-gray-800 dark:text-white appearance-none cursor-pointer">
                    <option value="">All Categories</option>
                    <option value="love">Love</option>
                    <option value="nature">Nature</option>
                    <option value="life">Life</option>
                    <option value="death">Death</option>
                    <option value="war">War</option>
                    <option value="peace">Peace</option>
                </select>
            </div>

            <!-- Sort By -->
            <div>
                <label for="sort" class="block text-xs font-medium text-gray-500 dark:text-gray-400 mb-1.5 uppercase tracking-wide">Sort By</label>
                <select id="sort"
                    class="w-full px-3 py-2.5 border border-gray-200 dark:border-gray-700 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500 focus:outline-none text-sm bg-white dark:bg-gray-800 dark:text-white appearance-none cursor-pointer">
                    <option value="newest">Newest First</option>
                    <option value="oldest">Oldest First</option>
                    <option value="popular">Most Popular</option>
                    <option value="title">Title A-Z</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Poems Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($poems as $poem)
            @php
                $userLiked = auth()->check() && $poem->userInteractions->where('user_id', auth()->id())->where('type', 'like')->count() > 0;
                $userRating = auth()->check() ? ($poem->userInteractions->where('user_id', auth()->id())->where('type', 'rating')->first()?->rating ?? 0) : 0;
                $likesCount = $poem->userInteractions->where('type', 'like')->count();
                $commentsCount = $poem->comments->count();
            @endphp
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 hover:shadow-md hover:border-blue-200 dark:hover:border-blue-900 transition-all group"
                 data-poem-card
                 data-poem-id="{{ $poem->id }}"
                 data-initial-liked="{{ $userLiked ? 'true' : 'false' }}"
                 data-initial-rating="{{ $userRating }}">

                <!-- Card Content -->
                <div class="p-5">
                    <!-- Author Info -->
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center flex-shrink-0">
                            <span class="text-white text-sm font-medium">{{ strtoupper(substr($poem->author->first_name ?? $poem->author->username ?? 'A', 0, 1)) }}{{ strtoupper(substr($poem->author->last_name ?? '', 0, 1)) }}</span>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900 dark:text-white truncate">{{ $poem->author->first_name ?? 'Anonymous' }} {{ $poem->author->last_name ?? '' }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $poem->created_at->diffForHumans() }}</p>
                        </div>
                    </div>

                    <!-- Title -->
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-3 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">
                        <a href="{{ route('poetry.show', $poem) }}" class="hover:underline decoration-1 underline-offset-2">
                            {{ $poem->title }}
                        </a>
                    </h3>

                    <!-- Poem Excerpt -->
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4 line-clamp-3 leading-relaxed">
                        {{ Str::limit($poem->content, 120) }}
                    </p>

                    <!-- Engagement Row -->
                    <div class="flex items-center justify-between pt-4 border-t border-gray-100 dark:border-gray-800">
                        <div class="flex items-center gap-4">
                            <!-- Likes -->
                            <button data-like-button
                                    class="flex items-center gap-1.5 text-sm transition-colors {{ $userLiked ? 'text-red-500' : 'text-gray-500 dark:text-gray-400 hover:text-red-500' }}">
                                <i class="{{ $userLiked ? 'bx bxs-heart' : 'bx bx-heart' }} text-lg"></i>
                                <span data-likes-count>{{ $likesCount }}</span>
                            </button>

                            <!-- Comments -->
                            <a href="{{ route('poetry.show', $poem) }}#comments" class="flex items-center gap-1.5 text-sm text-gray-500 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">
                                <i class="bx bx-comment text-lg"></i>
                                <span>{{ $commentsCount }}</span>
                            </a>

                            <!-- Rating Stars -->
                            <div class="flex items-center gap-0.5" data-rating-container>
                                @for($i = 1; $i <= 5; $i++)
                                    <button data-rating="{{ $i }}"
                                            class="transition-colors cursor-pointer {{ $userRating >= $i ? 'text-yellow-500' : 'text-gray-300 dark:text-gray-600 hover:text-yellow-400' }}">
                                        <i class="{{ $userRating >= $i ? 'bx bxs-star' : 'bx bx-star' }} text-sm"></i>
                                    </button>
                                @endfor
                            </div>
                        </div>

                        <!-- Read Link -->
                        <a href="{{ route('poetry.show', $poem) }}" class="flex items-center gap-1 text-xs font-medium text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 transition-colors">
                            Read
                            <i class="bx bx-right-arrow-alt text-base"></i>
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-12 text-center">
                    <div class="max-w-sm mx-auto">
                        <div class="w-20 h-20 bg-blue-50 dark:bg-blue-900/30 rounded-full flex items-center justify-center mx-auto mb-5">
                            <i class="bx bx-pen text-4xl text-blue-500 dark:text-blue-400"></i>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">No poems yet</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-6">Be the first to share your poetry with the community.</p>
                        @auth
                            <a href="{{ route('poetry.create') }}"
                               class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="bx bx-pen text-lg"></i>
                                Write Your First Poem
                            </a>
                        @else
                            <a href="{{ route('register') }}"
                               class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                <i class="bx bx-user-plus text-lg"></i>
                                Sign Up to Get Started
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($poems->hasPages())
        <div class="mt-8">
            {{ $poems->links() }}
        </div>
    @endif
</div>

<script>
// Poem card functionality (vanilla JavaScript)
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-poem-card]').forEach(card => {
        const poemId = card.getAttribute('data-poem-id');
        const initialLiked = card.getAttribute('data-initial-liked') === 'true';
        const initialRating = parseInt(card.getAttribute('data-initial-rating') || '0');

        let isLiked = initialLiked;
        let likesCount = parseInt(card.querySelector('[data-likes-count]')?.textContent || '0');
        let currentRating = initialRating;
        let hoverRating = 0;

        // Like button
        const likeButton = card.querySelector('[data-like-button]');
        if (likeButton) {
            likeButton.addEventListener('click', async function() {
                @guest
                    window.location.href = '/login';
                    return;
                @endguest

                try {
                    const response = await fetch(`/api/poems/${poemId}/like`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json'
                        },
                        credentials: 'same-origin'
                    });

                    if (response.ok) {
                        const data = await response.json();
                        isLiked = data.liked;
                        likesCount = data.likes_count;

                        const icon = likeButton.querySelector('i');
                        const countSpan = card.querySelector('[data-likes-count]');

                        if (icon) {
                            icon.className = isLiked ? 'bx bxs-heart text-lg' : 'bx bx-heart text-lg';
                        }
                        if (countSpan) {
                            countSpan.textContent = likesCount;
                        }
                        // Update button classes for like state
                        likeButton.classList.remove('text-red-500', 'text-gray-500', 'dark:text-gray-400');
                        if (isLiked) {
                            likeButton.classList.add('text-red-500');
                        } else {
                            likeButton.classList.add('text-gray-500', 'dark:text-gray-400');
                        }
                    }
                } catch (error) {
                    console.error('Error toggling like:', error);
                }
            });
        }

        // Rating buttons
        for (let i = 1; i <= 5; i++) {
            const ratingButton = card.querySelector(`[data-rating="${i}"]`);
            if (ratingButton) {
                ratingButton.addEventListener('click', async function() {
                    @guest
                        window.location.href = '/login';
                        return;
                    @endguest

                    try {
                        const response = await fetch(`/api/poems/${poemId}/rate`, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({ rating: i }),
                            credentials: 'same-origin'
                        });

                        if (response.ok) {
                            const data = await response.json();
                            currentRating = parseInt(data.rating);
                            updateRatingDisplay();
                        }
                    } catch (error) {
                        console.error('Error rating poem:', error);
                    }
                });

                ratingButton.addEventListener('mouseenter', function() {
                    hoverRating = i;
                    updateRatingDisplay();
                });

                ratingButton.addEventListener('mouseleave', function() {
                    hoverRating = 0;
                    updateRatingDisplay();
                });
            }
        }

        function updateRatingDisplay() {
            for (let i = 1; i <= 5; i++) {
                const btn = card.querySelector(`[data-rating="${i}"]`);
                const icon = btn?.querySelector('i');
                if (btn && icon) {
                    const isActive = hoverRating >= i || currentRating >= i;
                    icon.className = isActive ? 'bx bxs-star text-sm' : 'bx bx-star text-sm';
                    // Update button classes
                    btn.classList.remove('text-yellow-500', 'text-gray-300', 'dark:text-gray-600');
                    if (isActive) {
                        btn.classList.add('text-yellow-500');
                    } else {
                        btn.classList.add('text-gray-300', 'dark:text-gray-600');
                    }
                }
            }
        }
    });
});
</script>
@endsection
