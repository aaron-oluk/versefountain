@extends('layouts.app')

@section('title', ($creator->first_name ?? $creator->username) . ' - Creator Profile - VerseFountain')
@section('pageTitle', 'Creator Profile')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-950">
    <div class="max-w-6xl mx-auto px-3 sm:px-4 lg:px-8 py-6 sm:py-8">
        <!-- Profile Header Card -->
        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-5 sm:p-8 mb-6">
            <div class="flex flex-col sm:flex-row gap-6">
                <!-- Avatar -->
                <div class="w-24 h-24 sm:w-32 sm:h-32 bg-gray-100 dark:bg-gray-800 rounded-full flex items-center justify-center overflow-hidden flex-shrink-0">
                    @if($creator->profile_photo_path ?? false)
                        <img src="{{ asset('storage/' . $creator->profile_photo_path) }}" alt="{{ $creator->username }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-blue-600 dark:bg-blue-500 flex items-center justify-center">
                            <span class="text-3xl sm:text-4xl font-bold text-white">{{ strtoupper(substr($creator->first_name ?? $creator->username ?? 'U', 0, 1)) }}</span>
                        </div>
                    @endif
                </div>

                <!-- Profile Info -->
                <div class="flex-1">
                    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-4">
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-1">
                                {{ $creator->first_name ?? $creator->username }}
                                @if($creator->last_name) {{ $creator->last_name }} @endif
                            </h1>
                            <p class="text-gray-500 dark:text-gray-400 text-sm sm:text-base">{{ '@' . $creator->username }}</p>
                        </div>
                        <div class="flex gap-2 flex-shrink-0">
                            @auth
                                @if(auth()->id() !== $creator->id)
                                    <button onclick="toggleFollow({{ $creator->id }}, this)"
                                            class="px-4 sm:px-5 py-2 rounded-lg text-sm font-medium transition-colors {{ $isFollowing ? 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-700' : 'bg-blue-600 text-white hover:bg-blue-700' }}"
                                            data-following="{{ $isFollowing ? 'true' : 'false' }}">
                                        {{ $isFollowing ? 'Following' : 'Follow' }}
                                    </button>
                                    <a href="{{ route('chatrooms.index') }}" class="px-4 sm:px-5 py-2 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                                        Message
                                    </a>
                                @else
                                    <a href="{{ route('profile.edit') }}" class="px-4 sm:px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                        Edit Profile
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="px-4 sm:px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                    Follow
                                </a>
                            @endauth
                        </div>
                    </div>

                    <!-- Bio -->
                    @if($creator->bio ?? false)
                    <p class="text-gray-700 dark:text-gray-300 mb-4">{{ $creator->bio }}</p>
                    @endif

                    <!-- Stats -->
                    <div class="flex flex-wrap items-center gap-4 sm:gap-6 text-sm">
                        <div>
                            <span class="font-bold text-gray-900 dark:text-white" id="followerCount">{{ number_format($followerCount) }}</span>
                            <span class="text-gray-600 dark:text-gray-400 ml-1">Followers</span>
                        </div>
                        <div>
                            <span class="font-bold text-gray-900 dark:text-white">{{ number_format($followingCount) }}</span>
                            <span class="text-gray-600 dark:text-gray-400 ml-1">Following</span>
                        </div>
                        <div>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $poems->total() }}</span>
                            <span class="text-gray-600 dark:text-gray-400 ml-1">Poems</span>
                        </div>
                        <div>
                            <span class="font-bold text-gray-900 dark:text-white">{{ $publishedBooks->count() }}</span>
                            <span class="text-gray-600 dark:text-gray-400 ml-1">Books</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tabs -->
        <div class="mb-6">
            <nav class="flex gap-2">
                <button class="px-4 py-2 text-sm font-semibold text-white bg-blue-600 dark:bg-blue-500 rounded-lg transition-all hover:bg-blue-700 dark:hover:bg-blue-600" data-tab="poems">
                    <i class="bx bx-pen mr-1.5"></i>
                    Poems
                </button>
                <button class="px-4 py-2 text-sm font-semibold text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white hover:bg-gray-100 dark:hover:bg-gray-800 rounded-lg transition-all" data-tab="books">
                    <i class="bx bx-book mr-1.5"></i>
                    Books
                </button>
            </nav>
        </div>

        <!-- Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Poems Tab -->
                <div id="poems-tab">
                    @if($poems->count() > 0)
                        <div class="space-y-4">
                            @foreach($poems as $poem)
                            <a href="{{ route('poetry.show', $poem->id) }}" class="block bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-5 sm:p-6 hover:shadow-lg dark:hover:shadow-xl transition-all group">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors">{{ $poem->title }}</h3>
                                <p class="text-gray-600 dark:text-gray-400 text-sm mb-4 line-clamp-3">{{ Str::limit(strip_tags($poem->content), 200) }}</p>
                                <div class="flex items-center gap-4 sm:gap-6 text-xs sm:text-sm text-gray-500 dark:text-gray-400">
                                    <span class="flex items-center gap-1.5">
                                        <i class="bx bx-heart text-base"></i>
                                        {{ $poem->userInteractions()->where('liked', true)->count() }} likes
                                    </span>
                                    <span class="flex items-center gap-1.5">
                                        <i class="bx bx-comment text-base"></i>
                                        {{ $poem->comments()->count() }} comments
                                    </span>
                                    <span>{{ $poem->created_at->diffForHumans() }}</span>
                                </div>
                            </a>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $poems->links() }}
                        </div>
                    @else
                        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-12 sm:p-16 text-center">
                            <i class="bx bx-pen text-6xl text-gray-300 dark:text-gray-700 mb-4"></i>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No poems yet</h3>
                            <p class="text-gray-500 dark:text-gray-400">This creator hasn't published any poems.</p>
                        </div>
                    @endif
                </div>

                <!-- Books Tab (hidden by default) -->
                <div id="books-tab" class="hidden">
                    @if($publishedBooks->count() > 0)
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 sm:gap-5">
                            @foreach($publishedBooks as $book)
                            <a href="{{ route('books.show', $book) }}" class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 overflow-hidden hover:shadow-lg dark:hover:shadow-xl transition-all group">
                                <div class="aspect-[3/4] bg-gray-100 dark:bg-gray-800 flex items-center justify-center overflow-hidden">
                                    @if($book->coverImage)
                                        <img src="{{ asset('storage/' . $book->coverImage) }}" alt="{{ $book->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    @else
                                        <i class="bx bx-book text-4xl sm:text-5xl text-gray-300 dark:text-gray-700"></i>
                                    @endif
                                </div>
                                <div class="p-3 sm:p-4">
                                    <h3 class="font-semibold text-gray-900 dark:text-white text-sm sm:text-base line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors mb-1">{{ $book->title }}</h3>
                                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">{{ $book->genre ?? 'Poetry' }}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-12 sm:p-16 text-center">
                            <i class="bx bx-book text-6xl text-gray-300 dark:text-gray-700 mb-4"></i>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">No books yet</h3>
                            <p class="text-gray-500 dark:text-gray-400">This creator hasn't published any books.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="space-y-5 sm:space-y-6">
                <!-- About -->
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-5">
                    <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-4">About</h2>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-3 text-gray-600 dark:text-gray-400">
                            <i class="bx bx-calendar text-lg"></i>
                            <span>Joined {{ $creator->created_at->format('F Y') }}</span>
                        </div>
                        @if($creator->email && auth()->check() && (auth()->id() === $creator->id || auth()->user()->role === 'admin'))
                        <div class="flex items-center gap-3 text-gray-600 dark:text-gray-400">
                            <i class="bx bx-envelope text-lg"></i>
                            <span class="break-all">{{ $creator->email }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Featured Work -->
                @if($publishedBooks->count() > 0)
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-5">
                    <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-4">Featured Work</h2>
                    @php $featuredBook = $publishedBooks->first(); @endphp
                    <a href="{{ route('books.show', $featuredBook) }}" class="block group">
                        <div class="aspect-[3/4] bg-gray-100 dark:bg-gray-800 rounded-lg mb-3 overflow-hidden">
                            @if($featuredBook->coverImage)
                                <img src="{{ asset('storage/' . $featuredBook->coverImage) }}" alt="{{ $featuredBook->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="bx bx-book text-4xl text-gray-300 dark:text-gray-700"></i>
                                </div>
                            @endif
                        </div>
                        <h3 class="font-semibold text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors mb-1">{{ $featuredBook->title }}</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ $featuredBook->genre ?? 'Poetry Collection' }}</p>
                    </a>
                </div>
                @endif

                <!-- Similar Creators -->
                @php
                    $similarCreators = \App\Models\User::where('id', '!=', $creator->id)
                        ->has('poems')
                        ->withCount('poems')
                        ->orderBy('poems_count', 'desc')
                        ->take(3)
                        ->get();
                @endphp
                @if($similarCreators->count() > 0)
                <div class="bg-white dark:bg-gray-900 rounded-xl border border-gray-200 dark:border-gray-800 p-5">
                    <h2 class="text-base font-semibold text-gray-900 dark:text-white mb-4">Similar Creators</h2>
                    <div class="space-y-3">
                        @foreach($similarCreators as $similar)
                        <a href="{{ route('profile.creator', $similar->id) }}" class="flex items-center gap-3 hover:bg-gray-50 dark:hover:bg-gray-800 -mx-2 px-2 py-2 rounded-lg transition-colors">
                            <div class="w-10 h-10 bg-blue-600 dark:bg-blue-500 rounded-full flex items-center justify-center text-white font-semibold flex-shrink-0">
                                {{ strtoupper(substr($similar->first_name ?? $similar->username, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900 dark:text-white truncate">{{ $similar->first_name ?? $similar->username }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ $similar->poems_count }} poems</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                </div>
                @endif
            </aside>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Tab switching
document.querySelectorAll('[data-tab]').forEach(tab => {
    tab.addEventListener('click', function() {
        const tabName = this.dataset.tab;

        // Update tab styles
        document.querySelectorAll('[data-tab]').forEach(t => {
            t.classList.remove('bg-blue-600', 'dark:bg-blue-500', 'text-white', 'hover:bg-blue-700', 'dark:hover:bg-blue-600');
            t.classList.add('text-gray-600', 'dark:text-gray-400', 'hover:text-gray-900', 'dark:hover:text-white', 'hover:bg-gray-100', 'dark:hover:bg-gray-800');
        });
        this.classList.remove('text-gray-600', 'dark:text-gray-400', 'hover:text-gray-900', 'dark:hover:text-white', 'hover:bg-gray-100', 'dark:hover:bg-gray-800');
        this.classList.add('bg-blue-600', 'dark:bg-blue-500', 'text-white', 'hover:bg-blue-700', 'dark:hover:bg-blue-600');

        // Show/hide content
        document.getElementById('poems-tab').classList.toggle('hidden', tabName !== 'poems');
        document.getElementById('books-tab').classList.toggle('hidden', tabName !== 'books');
    });
});

// Follow/Unfollow
function toggleFollow(userId, button) {
    const isFollowing = button.dataset.following === 'true';
    const url = isFollowing
        ? `/api/poets/${userId}/unfollow`
        : `/api/poets/${userId}/follow`;

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        const followerCountEl = document.getElementById('followerCount');
        let count = parseInt(followerCountEl.textContent.replace(/,/g, ''));

        if (isFollowing) {
            button.dataset.following = 'false';
            button.textContent = 'Follow';
            button.classList.remove('bg-gray-100', 'dark:bg-gray-800', 'text-gray-700', 'dark:text-gray-300', 'hover:bg-gray-200', 'dark:hover:bg-gray-700');
            button.classList.add('bg-blue-600', 'text-white', 'hover:bg-blue-700');
            followerCountEl.textContent = (count - 1).toLocaleString();
        } else {
            button.dataset.following = 'true';
            button.textContent = 'Following';
            button.classList.remove('bg-blue-600', 'text-white', 'hover:bg-blue-700');
            button.classList.add('bg-gray-100', 'dark:bg-gray-800', 'text-gray-700', 'dark:text-gray-300', 'hover:bg-gray-200', 'dark:hover:bg-gray-700');
            followerCountEl.textContent = (count + 1).toLocaleString();
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endsection
