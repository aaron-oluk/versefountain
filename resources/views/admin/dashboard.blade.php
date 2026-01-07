@extends('layouts.app')

@section('title', 'Admin Dashboard - VerseFountain')

@php
    $totalUsers = \App\Models\User::count();
    $activeCreators = \App\Models\User::where('role', '!=', 'admin')->count();
    $newSubmissions = \App\Models\Poem::where('approved', false)->count() + \App\Models\Book::where('approved', false)->count();
    $reportedContent = 2; // Mock data
    $activeChatrooms = \App\Models\ChatRoom::withCount('members')->get();
    $mostReadContent = \App\Models\Book::where('approved', true)->orderBy('id', 'desc')->take(5)->get();
@endphp

@section('content')
<div class="min-h-screen bg-gray-50">
    <!-- Header -->
    <div class="mb-6">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h1 class="text-3xl font-semibold text-gray-900 mb-2">Executive Overview</h1>
                <p class="text-sm text-gray-600">Track performance across content, users, and revenue.</p>
            </div>
            <div class="flex items-center gap-3">
                <button class="flex items-center px-4 py-2 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium text-gray-700">
                    <i class="bx bx-calendar mr-2"></i>
                    Last 30 Days
                </button>
                <button class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                    <i class="bx bx-download mr-2"></i>
                    Generate Report
                </button>
            </div>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Daily Active Users -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Daily Active Users</p>
                    <p class="text-3xl font-semibold text-gray-900">4,821</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="bx bx-user-plus text-2xl text-blue-600"></i>
                </div>
            </div>
            <div class="flex items-center text-sm text-green-600">
                <i class="bx bx-trending-up mr-1"></i>
                <span>+8% vs last week</span>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Revenue</p>
                    <p class="text-3xl font-semibold text-gray-900">$24,500</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center">
                    <i class="bx bx-dollar text-2xl text-green-600"></i>
                </div>
            </div>
            <div class="flex items-center text-sm text-green-600">
                <i class="bx bx-trending-up mr-1"></i>
                <span>+15% subscription growth</span>
            </div>
        </div>

        <!-- Content Reads -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Content Reads</p>
                    <p class="text-3xl font-semibold text-gray-900">142.5k</p>
                </div>
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="bx bx-book-open text-2xl text-purple-600"></i>
                </div>
            </div>
            <p class="text-sm text-gray-600">Avg. 12 mins read time</p>
        </div>

        <!-- Active Chatrooms -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Active Chatrooms</p>
                    <p class="text-3xl font-semibold text-gray-900">86</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="bx bx-message-dots text-2xl text-orange-600"></i>
                </div>
            </div>
            <p class="text-sm text-gray-600">1,204 messages/hr</p>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Financial & User Growth -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-6">
            <div class="mb-4">
                <h2 class="text-lg font-semibold text-gray-900 mb-1">Financial & User Growth</h2>
                <p class="text-sm text-gray-600">Revenue vs New Subscriptions.</p>
            </div>
            <div class="flex items-center gap-4 mb-4">
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-blue-600 rounded-full"></div>
                    <span class="text-sm text-gray-600">Revenue</span>
                </div>
                <div class="flex items-center gap-2">
                    <div class="w-3 h-3 bg-green-600 rounded-full"></div>
                    <span class="text-sm text-gray-600">Subs</span>
                </div>
            </div>
            <!-- Chart Placeholder -->
            <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center border border-gray-200">
                <div class="text-center">
                    <i class="bx bx-line-chart text-4xl text-gray-400 mb-2"></i>
                    <p class="text-sm text-gray-500">Chart visualization</p>
                </div>
            </div>
        </div>

        <!-- Chatroom Activity -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Chatroom Activity</h2>
                <span class="px-2 py-1 bg-green-100 text-green-700 text-xs font-semibold rounded-full">LIVE</span>
            </div>
            <div class="space-y-4">
                @foreach($activeChatrooms->take(3) as $room)
                <div class="border-b border-gray-200 pb-4 last:border-0 last:pb-0">
                    <div class="flex items-center gap-2 mb-1">
                        <i class="bx bx-hash text-gray-400"></i>
                        <h3 class="text-sm font-semibold text-gray-900">{{ $room->name }}</h3>
                    </div>
                    <div class="flex items-center justify-between text-xs text-gray-600">
                        <span>{{ $room->members_count ?? $room->members->count() }} users online</span>
                        <span>{{ rand(1, 3) }}.{{ rand(1, 9) }}k msgs</span>
                    </div>
                </div>
                @endforeach
            </div>
            <button class="w-full mt-4 px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                View All Rooms
            </button>
        </div>
    </div>

    <!-- Bottom Row -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Most Read Content -->
        <div class="lg:col-span-2 bg-white rounded-lg shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold text-gray-900">Most Read Content</h2>
                <select class="text-sm border border-gray-300 rounded-lg px-3 py-1.5 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option>Filter by: Engagement</option>
                    <option>Filter by: Reads</option>
                    <option>Filter by: Revenue</option>
                </select>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="border-b border-gray-200">
                            <th class="text-left py-3 px-4 text-xs font-medium text-gray-600 uppercase">Title</th>
                            <th class="text-left py-3 px-4 text-xs font-medium text-gray-600 uppercase">Total Reads</th>
                            <th class="text-left py-3 px-4 text-xs font-medium text-gray-600 uppercase">Engagement Rate</th>
                            <th class="text-left py-3 px-4 text-xs font-medium text-gray-600 uppercase">Revenue Gen.</th>
                            <th class="text-left py-3 px-4 text-xs font-medium text-gray-600 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mostReadContent as $book)
                        <tr class="border-b border-gray-100 hover:bg-gray-50">
                            <td class="py-3 px-4">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $book->title }}</p>
                                    <p class="text-xs text-gray-600">by {{ $book->author }}</p>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-900">{{ number_format(rand(10000, 50000)) }}</td>
                            <td class="py-3 px-4">
                                <div class="flex items-center gap-2">
                                    <div class="w-24 h-2 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-green-500" style="width: {{ rand(80, 95) }}%"></div>
                                    </div>
                                    <span class="text-sm text-gray-900">{{ rand(80, 95) }}%</span>
                                </div>
                            </td>
                            <td class="py-3 px-4 text-sm text-gray-900">${{ number_format(rand(500, 2000), 2) }}</td>
                            <td class="py-3 px-4">
                                <button class="text-blue-600 hover:text-blue-700">
                                    <i class="bx bx-show text-lg"></i>
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Login Frequency -->
        <div class="bg-white rounded-lg shadow-sm p-6">
            <h2 class="text-lg font-semibold text-gray-900 mb-4">Login Frequency</h2>
            <!-- Chart Placeholder -->
            <div class="h-64 bg-gray-50 rounded-lg flex items-center justify-center border border-gray-200">
                <div class="text-center">
                    <i class="bx bx-bar-chart-alt-2 text-4xl text-gray-400 mb-2"></i>
                    <p class="text-sm text-gray-500">Chart visualization</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
