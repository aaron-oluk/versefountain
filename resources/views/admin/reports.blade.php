@extends('layouts.app')

@section('title', 'Reports & Analytics - Admin')

@section('content')
    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-4 sm:py-8">
        <!-- Page Header -->
        <div class="mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">Reports & Analytics</h1>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Platform insights and statistics</p>
                </div>
                <form method="GET" class="flex items-center gap-2">
                    <select name="period" onchange="this.form.submit()"
                        class="px-4 py-2 text-sm border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <option value="7" {{ $period == '7' ? 'selected' : '' }}>Last 7 days</option>
                        <option value="30" {{ $period == '30' ? 'selected' : '' }}>Last 30 days</option>
                        <option value="90" {{ $period == '90' ? 'selected' : '' }}>Last 90 days</option>
                        <option value="365" {{ $period == '365' ? 'selected' : '' }}>Last year</option>
                    </select>
                </form>
            </div>
        </div>

        <!-- Content Stats -->
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 mb-6">
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Books</h3>
                    <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                        <i class="bx bx-book text-lg text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white mb-1">{{ $contentStats['total_books'] }}</p>
                <div class="flex items-center gap-2 text-xs">
                    <span class="text-green-600 dark:text-green-400">+{{ $contentStats['new_books'] }} new</span>
                    <span class="text-gray-400">|</span>
                    <span class="text-amber-600 dark:text-amber-400">{{ $contentStats['pending_books'] }} pending</span>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Poems</h3>
                    <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                        <i class="bx bx-pen text-lg text-purple-600 dark:text-purple-400"></i>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white mb-1">{{ $contentStats['total_poems'] }}</p>
                <div class="flex items-center gap-2 text-xs">
                    <span class="text-green-600 dark:text-green-400">+{{ $contentStats['new_poems'] }} new</span>
                    <span class="text-gray-400">|</span>
                    <span class="text-amber-600 dark:text-amber-400">{{ $contentStats['pending_poems'] }} pending</span>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Chatrooms</h3>
                    <div class="w-8 h-8 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                        <i class="bx bx-message-dots text-lg text-green-600 dark:text-green-400"></i>
                    </div>
                </div>
                <p class="text-2xl font-bold text-gray-900 dark:text-white mb-1">{{ $chatroomStats['total_rooms'] }}</p>
                <div class="flex items-center gap-2 text-xs">
                    <span class="text-green-600 dark:text-green-400">{{ $chatroomStats['active_rooms'] }} active</span>
                </div>
            </div>
        </div>

        <!-- Event Stats -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4">
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Total Events</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $eventStats['total_events'] }}</p>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4">
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Upcoming Events</p>
                <p class="text-xl font-bold text-blue-600 dark:text-blue-400">{{ $eventStats['upcoming_events'] }}</p>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4">
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Total Tickets</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $eventStats['total_tickets'] }}</p>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4">
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Active Tickets</p>
                <p class="text-xl font-bold text-green-600 dark:text-green-400">{{ $eventStats['tickets_sold'] }}</p>
            </div>
        </div>

        <!-- User Growth Chart -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 sm:p-6 mb-6">
            <h2 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-4">User Growth</h2>
            <div class="h-64 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-lg flex items-center justify-center border border-gray-200 dark:border-gray-700">
                <div class="text-center">
                    <i class="bx bx-line-chart text-4xl text-gray-300 dark:text-gray-600 mb-2"></i>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">User growth visualization</p>
                    @if($userGrowth->count() > 0)
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">{{ $userGrowth->sum('count') }} new users in the last {{ $period }} days</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Top Creators -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-800">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">Top Creators</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Rank</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Creator</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Poems</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Books</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($topCreators as $index => $creator)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                <td class="py-3 px-4">
                                    <span class="text-sm font-bold text-gray-500 dark:text-gray-400">#{{ $index + 1 }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                            {{ strtoupper(substr($creator->username, 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $creator->username }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $creator->poems_count }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $creator->books_count }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $creator->poems_count + $creator->books_count }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">No creators found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
