@extends('layouts.app')

@section('title', 'Users Management - Admin')

@section('content')
    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-4 sm:py-8">
        <!-- Page Header -->
        <div class="mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">Users Management</h1>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Manage all registered users</p>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Total Users</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $stats['total_users'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                        <i class="bx bx-user text-xl text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Admins</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $stats['admins'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                        <i class="bx bx-shield text-xl text-purple-600 dark:text-purple-400"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Creators</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $stats['creators'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                        <i class="bx bx-pen text-xl text-green-600 dark:text-green-400"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Regular Users</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $stats['regular'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-800 rounded-lg flex items-center justify-center">
                        <i class="bx bx-user-circle text-xl text-gray-600 dark:text-gray-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 mb-6">
            <form method="GET" class="flex flex-col sm:flex-row gap-3">
                <div class="flex-1">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Search by username or email..."
                        class="w-full px-4 py-2 text-sm border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <select name="role" onchange="this.form.submit()"
                    class="px-4 py-2 text-sm border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all" {{ $role === 'all' ? 'selected' : '' }}>All Roles</option>
                    <option value="admin" {{ $role === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="creator" {{ $role === 'creator' ? 'selected' : '' }}>Creator</option>
                    <option value="user" {{ $role === 'user' ? 'selected' : '' }}>User</option>
                </select>
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                    Search
                </button>
            </form>
        </div>

        <!-- Users Table -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">User</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Email</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Role</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Joined</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($users as $user)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                            {{ strtoupper(substr($user->username, 0, 1)) }}
                                        </div>
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->username }}</span>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $user->email }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    @php
                                        $roleColors = [
                                            'admin' => 'bg-purple-100 dark:bg-purple-900/20 text-purple-700 dark:text-purple-400',
                                            'creator' => 'bg-green-100 dark:bg-green-900/20 text-green-700 dark:text-green-400',
                                            'user' => 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-400',
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-medium rounded {{ $roleColors[$user->role] ?? $roleColors['user'] }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $user->created_at->format('M d, Y') }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('profile.creator', $user) }}" class="text-blue-600 dark:text-blue-400 hover:text-blue-700 text-sm">View</a>
                                        @if($user->id !== auth()->id())
                                            <form method="POST" action="{{ route('api.admin.users.delete', $user) }}" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-700 text-sm">Delete</button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">No users found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($users->hasPages())
                <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-800">
                    {{ $users->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
