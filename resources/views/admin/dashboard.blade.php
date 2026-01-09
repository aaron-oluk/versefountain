@extends('layouts.app')

@section('title', 'Admin Dashboard - VerseFountain')

@section('content')
    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-4 sm:py-8">
        <!-- Page Header -->
        <div class="mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">Admin Dashboard</h1>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Track performance across your platform</p>
                </div>
                <div class="flex items-center gap-2">
                    <button
                        class="flex items-center px-3 sm:px-4 py-2 border border-gray-200 dark:border-gray-700 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors text-xs sm:text-sm font-medium text-gray-700 dark:text-gray-300">
                        <i class="bx bx-calendar mr-2"></i>
                        Last 30 Days
                    </button>
                    <button
                        class="flex items-center px-3 sm:px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-xs sm:text-sm font-medium">
                        <i class="bx bx-download mr-2"></i>
                        Report
                    </button>
                </div>
            </div>
        </div>

        <!-- KPI Cards Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6 sm:mb-8">
            <!-- Total Users Card -->
            <div
                class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-1">Total Users</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                            {{ $stats['total_users'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                        <i class="bx bx-user text-2xl text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
                <div class="flex items-center text-xs sm:text-sm text-green-600 dark:text-green-400">
                    <i class="bx bx-trending-up mr-1"></i>
                    <span>+12% this month</span>
                </div>
            </div>

            <!-- Active Creators Card -->
            <div
                class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-1">Active Creators</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                            {{ $stats['active_creators'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                        <i class="bx bx-user-check text-2xl text-green-600 dark:text-green-400"></i>
                    </div>
                </div>
                <div class="flex items-center text-xs sm:text-sm text-green-600 dark:text-green-400">
                    <i class="bx bx-trending-up mr-1"></i>
                    <span>+5 new creators</span>
                </div>
            </div>

            <!-- Pending Submissions Card -->
            <div
                class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-1">Pending Review</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                            {{ $stats['pending_submissions'] ?? 0 }}</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-100 dark:bg-amber-900/20 rounded-lg flex items-center justify-center">
                        <i class="bx bx-time text-2xl text-amber-600 dark:text-amber-400"></i>
                    </div>
                </div>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">Awaiting approval</p>
            </div>

            <!-- Active Chatrooms Card -->
            <div
                class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <div>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400 mb-1">Active Chatrooms</p>
                        <p class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white">
                            {{ $activeChatrooms->count() }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                        <i class="bx bx-message-dots text-2xl text-purple-600 dark:text-purple-400"></i>
                    </div>
                </div>
                <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">{{ rand(800, 1500) }} msgs/hr</p>
            </div>
        </div>

        <!-- Charts and Activity Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6 sm:mb-8">
            <!-- Growth Chart -->
            <div
                class="lg:col-span-2 bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 sm:p-6">
                <div class="mb-6">
                    <h2 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-1">Growth Overview</h2>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">User growth and content submissions</p>
                </div>
                <div
                    class="h-64 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-lg flex items-center justify-center border border-gray-200 dark:border-gray-700">
                    <div class="text-center">
                        <i class="bx bx-line-chart text-4xl text-gray-300 dark:text-gray-600 mb-2"></i>
                        <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Chart visualization</p>
                    </div>
                </div>
            </div>

            <!-- Chatroom Activity -->
            <div
                class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 sm:p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">Top Chatrooms</h2>
                    <span
                        class="px-2.5 py-1 bg-green-100 dark:bg-green-900/20 text-green-700 dark:text-green-400 text-xs font-semibold rounded-full">LIVE</span>
                </div>
                <div class="space-y-3">
                    @forelse($activeChatrooms->take(4) as $room)
                        <div class="pb-3 border-b border-gray-100 dark:border-gray-800 last:border-0 last:pb-0">
                            <div class="flex items-start justify-between mb-1">
                                <div class="flex items-center gap-2 min-w-0">
                                    <i class="bx bx-hash text-gray-400 flex-shrink-0"></i>
                                    <h3 class="text-xs sm:text-sm font-semibold text-gray-900 dark:text-white truncate">
                                        {{ $room->name }}</h3>
                                </div>
                                <span class="w-2 h-2 bg-green-500 rounded-full flex-shrink-0 mt-1"></span>
                            </div>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ $room->members_count ?? $room->members->count() }} members</p>
                        </div>
                    @empty
                        <p class="text-xs text-gray-500 dark:text-gray-400">No active chatrooms</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Content Table -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 sm:p-6">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-4 mb-6">
                <div>
                    <h2 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-1">Recent Content</h2>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Latest submissions and activity</p>
                </div>
                <form method="GET" class="flex flex-wrap items-center gap-2 sm:gap-3">
                    <select name="status" onchange="this.form.submit()"
                        class="text-xs sm:text-sm border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all" {{ $statusFilter === 'all' ? 'selected' : '' }}>All statuses</option>
                        <option value="pending" {{ $statusFilter === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="approved" {{ $statusFilter === 'approved' ? 'selected' : '' }}>Approved</option>
                    </select>
                    <select name="type" onchange="this.form.submit()"
                        class="text-xs sm:text-sm border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="all" {{ $typeFilter === 'all' ? 'selected' : '' }}>All types</option>
                        <option value="book" {{ $typeFilter === 'book' ? 'selected' : '' }}>Books</option>
                        <option value="poem" {{ $typeFilter === 'poem' ? 'selected' : '' }}>Poems</option>
                    </select>
                </form>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-200 dark:border-gray-700">
                            <th
                                class="text-left py-2 sm:py-3 px-3 sm:px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                                Title</th>
                            <th
                                class="text-left py-2 sm:py-3 px-3 sm:px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                                Author</th>
                            <th
                                class="text-left py-2 sm:py-3 px-3 sm:px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                                Type</th>
                            <th
                                class="text-left py-2 sm:py-3 px-3 sm:px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                                Submitted</th>
                            <th
                                class="text-left py-2 sm:py-3 px-3 sm:px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                                Status</th>
                            <th
                                class="text-left py-2 sm:py-3 px-3 sm:px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">
                                Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contentItems->take(8) as $item)
                            <tr
                                class="border-b border-gray-100 dark:border-gray-800 hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                <td class="py-3 px-3 sm:px-4">
                                    <p class="text-xs sm:text-sm font-medium text-gray-900 dark:text-white truncate">
                                        {{ $item['title'] }}</p>
                                </td>
                                <td class="py-3 px-3 sm:px-4">
                                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">{{ $item['author'] }}
                                    </p>
                                </td>
                                <td class="py-3 px-3 sm:px-4">
                                    <span
                                        class="px-2 py-1 bg-blue-100 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400 text-xs font-medium rounded">{{ ucfirst($item['type']) }}</span>
                                </td>
                                <td class="py-3 px-3 sm:px-4">
                                    <p class="text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                                        {{ optional($item['created_at'])->format('M d, Y') }}</p>
                                </td>
                                <td class="py-3 px-3 sm:px-4">
                                    @if ($item['status'] === 'approved')
                                        <span
                                            class="px-2 py-1 bg-green-100 dark:bg-green-900/20 text-green-700 dark:text-green-400 text-xs font-medium rounded">Approved</span>
                                    @else
                                        <span
                                            class="px-2 py-1 bg-amber-100 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400 text-xs font-medium rounded">Pending</span>
                                    @endif
                                </td>
                                <td class="py-3 px-3 sm:px-4">
                                    <div class="flex items-center gap-2">
                                        @if ($item['status'] === 'pending')
                                            @if ($item['type'] === 'book')
                                                <form method="POST"
                                                    action="{{ route('api.admin.books.approve', $item['model']) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button
                                                        class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 text-xs sm:text-sm font-semibold">Approve</button>
                                                </form>
                                            @else
                                                <form method="POST"
                                                    action="{{ route('api.admin.poems.approve', $item['model']) }}">
                                                    @csrf
                                                    <button
                                                        class="text-green-600 dark:text-green-400 hover:text-green-700 dark:hover:text-green-300 text-xs sm:text-sm font-semibold">Approve</button>
                                                </form>
                                            @endif
                                        @endif

                                        @if ($item['type'] === 'book')
                                            <form method="POST"
                                                action="{{ route('api.admin.books.delete', $item['model']) }}"
                                                onsubmit="return confirm('Delete this book?');">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 text-xs sm:text-sm font-semibold">Delete</button>
                                            </form>
                                            <a href="{{ route('books.show', $item['model']) }}"
                                                class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300"
                                                title="View">
                                                <i class="bx bx-show text-lg"></i>
                                            </a>
                                        @else
                                            <form method="POST"
                                                action="{{ route('api.admin.poems.delete', $item['model']) }}"
                                                onsubmit="return confirm('Delete this poem?');">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="text-red-600 dark:text-red-400 hover:text-red-700 dark:hover:text-red-300 text-xs sm:text-sm font-semibold">Delete</button>
                                            </form>
                                            <a href="{{ route('api.poems.show', $item['model']) }}"
                                                class="text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300"
                                                title="View">
                                                <i class="bx bx-show text-lg"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-8 px-4 text-center">
                                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">No content available</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
