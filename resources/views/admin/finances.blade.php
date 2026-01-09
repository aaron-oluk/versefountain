@extends('layouts.app')

@section('title', 'Finances - Admin')

@section('content')
    <div class="max-w-7xl mx-auto px-3 sm:px-4 py-4 sm:py-8">
        <!-- Page Header -->
        <div class="mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">Finances</h1>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Track revenue and payments</p>
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

        <!-- Revenue Stats -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4 mb-6">
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-sm p-4 text-white">
                <p class="text-sm opacity-80 mb-1">Total Revenue</p>
                <p class="text-2xl font-bold">${{ number_format($stats['total_revenue'], 2) }}</p>
            </div>
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-sm p-4 text-white">
                <p class="text-sm opacity-80 mb-1">Period Revenue</p>
                <p class="text-2xl font-bold">${{ number_format($stats['period_revenue'], 2) }}</p>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4">
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Total Payments</p>
                <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $stats['total_payments'] }}</p>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4">
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Pending</p>
                <p class="text-xl font-bold text-amber-600 dark:text-amber-400">{{ $stats['pending_payments'] }}</p>
            </div>
        </div>

        <!-- Refund Stats -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4 mb-6">
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Total Refunded</p>
                        <p class="text-xl font-bold text-red-600 dark:text-red-400">${{ number_format($stats['refunded_total'], 2) }}</p>
                    </div>
                    <div class="w-10 h-10 bg-red-100 dark:bg-red-900/20 rounded-lg flex items-center justify-center">
                        <i class="bx bx-undo text-xl text-red-600 dark:text-red-400"></i>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Refund Count</p>
                        <p class="text-xl font-bold text-gray-900 dark:text-white">{{ $stats['refunded_count'] }}</p>
                    </div>
                    <div class="w-10 h-10 bg-gray-100 dark:bg-gray-800 rounded-lg flex items-center justify-center">
                        <i class="bx bx-receipt text-xl text-gray-600 dark:text-gray-400"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Revenue Chart Placeholder -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 p-4 sm:p-6 mb-6">
            <h2 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white mb-4">Revenue Over Time</h2>
            <div class="h-64 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-lg flex items-center justify-center border border-gray-200 dark:border-gray-700">
                <div class="text-center">
                    <i class="bx bx-line-chart text-4xl text-gray-300 dark:text-gray-600 mb-2"></i>
                    <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">Revenue chart visualization</p>
                    @if($revenueByDay->count() > 0)
                        <p class="text-xs text-gray-400 dark:text-gray-500 mt-2">{{ $revenueByDay->count() }} days of data</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Payments Table -->
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-100 dark:border-gray-800 overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-100 dark:border-gray-800">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white">Recent Payments</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">User</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Amount</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Status</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Date</th>
                            <th class="text-left py-3 px-4 text-xs font-semibold text-gray-600 dark:text-gray-400 uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 dark:divide-gray-800">
                        @forelse($payments as $payment)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800/50">
                                <td class="py-3 px-4">
                                    <span class="text-sm text-gray-900 dark:text-white">{{ $payment->user->username ?? 'Unknown' }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-sm font-medium text-gray-900 dark:text-white">${{ number_format($payment->amount, 2) }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    @php
                                        $statusColors = [
                                            'completed' => 'bg-green-100 dark:bg-green-900/20 text-green-700 dark:text-green-400',
                                            'pending' => 'bg-amber-100 dark:bg-amber-900/20 text-amber-700 dark:text-amber-400',
                                            'failed' => 'bg-red-100 dark:bg-red-900/20 text-red-700 dark:text-red-400',
                                            'refunded' => 'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-400',
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-medium rounded {{ $statusColors[$payment->status] ?? $statusColors['pending'] }}">
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="text-sm text-gray-600 dark:text-gray-400">{{ $payment->created_at->format('M d, Y H:i') }}</span>
                                </td>
                                <td class="py-3 px-4">
                                    @if($payment->status === 'completed')
                                        <form method="POST" action="{{ route('api.admin.payments.refund', $payment) }}" onsubmit="return confirm('Are you sure you want to refund this payment?');">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-red-600 dark:text-red-400 hover:text-red-700 text-sm">Refund</button>
                                        </form>
                                    @else
                                        <span class="text-gray-400 text-sm">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center">
                                    <p class="text-sm text-gray-500 dark:text-gray-400">No payments found</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($payments->hasPages())
                <div class="px-4 py-3 border-t border-gray-100 dark:border-gray-800">
                    {{ $payments->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
