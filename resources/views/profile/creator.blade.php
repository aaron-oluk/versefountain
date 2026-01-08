@extends('layouts.app')

@section('title', ($creator->first_name ?? $creator->username) . ' - Creator Profile - VerseFountain')

@php $pageTitle = 'Creator Profile'; @endphp

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Banner -->
    <div class="h-48 sm:h-64 bg-gradient-to-r from-blue-600 via-purple-600 to-blue-700 relative">
        <div class="absolute inset-0 bg-black/20"></div>
    </div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 pb-12">
        <!-- Profile Header -->
        <div class="relative -mt-16 sm:-mt-20 mb-6">
            <div class="flex flex-col sm:flex-row sm:items-end gap-4">
                <!-- Avatar -->
                <div class="w-28 h-28 sm:w-36 sm:h-36 bg-white rounded-full border-4 border-white shadow-lg flex items-center justify-center overflow-hidden">
                    @if($creator->profile_photo_path ?? false)
                        <img src="{{ asset('storage/' . $creator->profile_photo_path) }}" alt="{{ $creator->username }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                            <span class="text-4xl sm:text-5xl font-bold text-white">{{ strtoupper(substr($creator->first_name ?? $creator->username ?? 'U', 0, 1)) }}</span>
                        </div>
                    @endif
                </div>

                <!-- Name and Actions -->
                <div class="flex-1 sm:pb-2">
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                        <div>
                            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">
                                {{ $creator->first_name ?? $creator->username }}
                                @if($creator->last_name) {{ $creator->last_name }} @endif
                            </h1>
                            <p class="text-gray-500">{{ '@' . $creator->username }}</p>
                        </div>
                        <div class="flex gap-2">
                            @auth
                                @if(auth()->id() !== $creator->id)
                                    <button onclick="toggleFollow({{ $creator->id }}, this)"
                                            class="px-5 py-2 rounded-lg text-sm font-medium transition-colors {{ $isFollowing ? 'bg-gray-200 text-gray-700 hover:bg-gray-300' : 'bg-blue-600 text-white hover:bg-blue-700' }}"
                                            data-following="{{ $isFollowing ? 'true' : 'false' }}">
                                        {{ $isFollowing ? 'Following' : 'Follow' }}
                                    </button>
                                    <a href="{{ route('chatrooms.index') }}" class="px-5 py-2 bg-white border border-gray-300 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-50 transition-colors">
                                        Message
                                    </a>
                                @else
                                    <a href="{{ route('profile.edit') }}" class="px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                        Edit Profile
                                    </a>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="px-5 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                                    Follow
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="flex items-center gap-6 mb-6 text-sm">
            <div>
                <span class="font-bold text-gray-900" id="followerCount">{{ number_format($followerCount) }}</span>
                <span class="text-gray-500">Followers</span>
            </div>
            <div>
                <span class="font-bold text-gray-900">{{ number_format($followingCount) }}</span>
                <span class="text-gray-500">Following</span>
            </div>
            <div>
                <span class="font-bold text-gray-900">{{ $poems->total() }}</span>
                <span class="text-gray-500">Poems</span>
            </div>
            <div>
                <span class="font-bold text-gray-900">{{ $publishedBooks->count() }}</span>
                <span class="text-gray-500">Books</span>
            </div>
        </div>

        <!-- Bio -->
        @if($creator->bio ?? false)
        <div class="mb-6">
            <p class="text-gray-700">{{ $creator->bio }}</p>
        </div>
        @endif

        <!-- Tabs -->
        <div class="border-b border-gray-200 mb-6">
            <nav class="flex -mb-px">
                <button class="px-4 py-3 text-sm font-medium text-blue-600 border-b-2 border-blue-600 transition-colors" data-tab="poems">
                    Poems
                </button>
                <button class="px-4 py-3 text-sm font-medium text-gray-600 hover:text-gray-900 border-b-2 border-transparent hover:border-gray-300 transition-colors" data-tab="books">
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
                            <a href="{{ route('poetry.show', $poem->id) }}" class="block bg-white rounded-xl border border-gray-200 p-5 hover:shadow-md transition-shadow">
                                <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $poem->title }}</h3>
                                <p class="text-gray-600 text-sm mb-3 line-clamp-3">{{ Str::limit(strip_tags($poem->content), 200) }}</p>
                                <div class="flex items-center gap-4 text-sm text-gray-500">
                                    <span class="flex items-center gap-1">
                                        <i class="bx bx-heart"></i>
                                        {{ $poem->userInteractions()->where('type', 'like')->count() }} likes
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <i class="bx bx-comment"></i>
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
                        <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
                            <i class="bx bx-pen text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No poems yet</h3>
                            <p class="text-gray-500">This creator hasn't published any poems.</p>
                        </div>
                    @endif
                </div>

                <!-- Books Tab (hidden by default) -->
                <div id="books-tab" class="hidden">
                    @if($publishedBooks->count() > 0)
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                            @foreach($publishedBooks as $book)
                            <a href="{{ route('books.show', $book->id) }}" class="bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
                                <div class="aspect-[3/4] bg-gradient-to-br from-gray-100 to-gray-200 flex items-center justify-center">
                                    @if($book->coverImage)
                                        <img src="{{ asset('storage/' . $book->coverImage) }}" alt="{{ $book->title }}" class="w-full h-full object-cover">
                                    @else
                                        <i class="bx bx-book text-4xl text-gray-400"></i>
                                    @endif
                                </div>
                                <div class="p-3">
                                    <h3 class="font-medium text-gray-900 text-sm truncate">{{ $book->title }}</h3>
                                    <p class="text-xs text-gray-500">{{ $book->genre ?? 'Poetry' }}</p>
                                </div>
                            </a>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white rounded-xl border border-gray-200 p-12 text-center">
                            <i class="bx bx-book text-6xl text-gray-300 mb-4"></i>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No books yet</h3>
                            <p class="text-gray-500">This creator hasn't published any books.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <aside class="space-y-6">
                <!-- About -->
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <h2 class="text-base font-semibold text-gray-900 mb-4">About</h2>
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center gap-3 text-gray-600">
                            <i class="bx bx-calendar text-lg"></i>
                            <span>Joined {{ $creator->created_at->format('F Y') }}</span>
                        </div>
                        @if($creator->email && auth()->check() && (auth()->id() === $creator->id || auth()->user()->role === 'admin'))
                        <div class="flex items-center gap-3 text-gray-600">
                            <i class="bx bx-envelope text-lg"></i>
                            <span>{{ $creator->email }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Featured Work -->
                @if($publishedBooks->count() > 0)
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <h2 class="text-base font-semibold text-gray-900 mb-4">Featured Work</h2>
                    @php $featuredBook = $publishedBooks->first(); @endphp
                    <a href="{{ route('books.show', $featuredBook->id) }}" class="block group">
                        <div class="aspect-[3/4] bg-gradient-to-br from-gray-100 to-gray-200 rounded-lg mb-3 overflow-hidden">
                            @if($featuredBook->coverImage)
                                <img src="{{ asset('storage/' . $featuredBook->coverImage) }}" alt="{{ $featuredBook->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                            @else
                                <div class="w-full h-full flex items-center justify-center">
                                    <i class="bx bx-book text-4xl text-gray-400"></i>
                                </div>
                            @endif
                        </div>
                        <h3 class="font-semibold text-gray-900 group-hover:text-blue-600 transition-colors">{{ $featuredBook->title }}</h3>
                        <p class="text-sm text-gray-500">{{ $featuredBook->genre ?? 'Poetry Collection' }}</p>
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
                <div class="bg-white rounded-xl border border-gray-200 p-5">
                    <h2 class="text-base font-semibold text-gray-900 mb-4">Similar Creators</h2>
                    <div class="space-y-3">
                        @foreach($similarCreators as $similar)
                        <a href="{{ route('profile.creator', $similar->id) }}" class="flex items-center gap-3 hover:bg-gray-50 -mx-2 px-2 py-2 rounded-lg transition-colors">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center text-white font-medium">
                                {{ strtoupper(substr($similar->first_name ?? $similar->username, 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-medium text-gray-900 truncate">{{ $similar->first_name ?? $similar->username }}</p>
                                <p class="text-xs text-gray-500">{{ $similar->poems_count }} poems</p>
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
            t.classList.remove('text-blue-600', 'border-blue-600');
            t.classList.add('text-gray-600', 'border-transparent');
        });
        this.classList.remove('text-gray-600', 'border-transparent');
        this.classList.add('text-blue-600', 'border-blue-600');

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
            button.classList.remove('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
            button.classList.add('bg-blue-600', 'text-white', 'hover:bg-blue-700');
            followerCountEl.textContent = (count - 1).toLocaleString();
        } else {
            button.dataset.following = 'true';
            button.textContent = 'Following';
            button.classList.remove('bg-blue-600', 'text-white', 'hover:bg-blue-700');
            button.classList.add('bg-gray-200', 'text-gray-700', 'hover:bg-gray-300');
            followerCountEl.textContent = (count + 1).toLocaleString();
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endsection
