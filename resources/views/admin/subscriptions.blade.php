@extends('layouts.app')

@section('title', 'Subscriptions Management - Admin')

@section('content')
    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-4 sm:py-8">
        <!-- Page Header -->
        <div class="mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">Subscriptions</h1>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Manage user subscriptions and plans</p>
                </div>
            </div>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4 mb-6">
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Total Subscriptions</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $stats['total_subscriptions'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                        <i class="bx bx-credit-card text-xl text-blue-600 dark:text-blue-400"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Active</p>
                        <p class="text-xl font-bold text-green-600 dark:text-green-400">{{ $stats['active'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                        <i class="bx bx-check-circle text-xl text-green-600 dark:text-green-400"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Cancelled</p>
                        <p class="text-xl font-bold text-red-600 dark:text-red-400">{{ $stats['cancelled'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-red-100 dark:bg-red-900/20 rounded-lg flex items-center justify-center">
                        <i class="bx bx-x-circle text-xl text-red-600 dark:text-red-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Cards -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 mb-6">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-sm p-4 text-white">
                <p class="text-sm opacity-80 mb-1">Monthly Revenue (MRR)</p>
                <p class="text-2xl font-bold">${{ number_format($stats['monthly_revenue'], 2) }}</p>
            </div>
            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-sm p-4 text-white">
                <p class="text-sm opacity-80 mb-1">Yearly Revenue (ARR)</p>
                <p class="text-2xl font-bold">${{ number_format($stats['yearly_revenue'], 2) }}</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 mb-6">
            <form method="GET" class="flex flex-wrap gap-3">
                <select name="status" onchange="this.form.submit()"
                    class="px-4 py-2 text-sm border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all" {{ $status === 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="active" {{ $status === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="cancelled" {{ $status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    <option value="past_due" {{ $status === 'past_due' ? 'selected' : '' }}>Past Due</option>
                </select>
                <select name="plan" onchange="this.form.submit()"
                    class="px-4 py-2 text-sm border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="all" {{ $plan === 'all' ? 'selected' : '' }}>All Plans</option>
                    <option value="monthly" {{ $plan === 'monthly' ? 'selected' : '' }}>Monthly</option>
                    <option value="yearly" {{ $plan === 'yearly' ? 'selected' : '' }}>Yearly</option>
                </select>
            </form>
        </div>

        <!-- Subscriptions Table -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">User</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Plan</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Amount</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Status</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Next Billing</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($subscriptions as $subscription)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                <td class="py-3 px-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                                            {{ strtoupper(substr($subscription->user->username ?? 'U', 0, 1)) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $subscription->user->username ?? 'Unknown' }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $subscription->user->email ?? '' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-sm text-gray-900 dark:text-white">{{ $subscription->plan_name ?? ucfirst($subscription->plan_type) }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">${{ number_format($subscription->amount, 2) }}</span>
                                    <span class="text-xs text-gray-500 dark:text-gray-400">/{{ $subscription->plan_type === 'yearly' ? 'year' : 'month' }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    @php
                                        $statusColors = [
                                            'active' => 'bg-green-100 dark:bg-green-900/20 text-green-700 dark:text-green-400',
                                            'cancelled' => 'bg-red-100 dark:bg-red-900/20 text-red-700 dark:text-red-400',
                                            'past_due' => 'bg-amber-100 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400',
                                            'trialing' => 'bg-blue-100 dark:bg-blue-900/20 text-blue-700 dark:text-blue-400',
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-medium rounded {{ $statusColors[$subscription->status] ?? $statusColors['active'] }}">
                                        {{ ucfirst($subscription->status) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $subscription->current_period_end ? $subscription->current_period_end->format('M d, Y') : '-' }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">No subscriptions found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($subscriptions->hasPages())
                <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-800">
                    {{ $subscriptions->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
