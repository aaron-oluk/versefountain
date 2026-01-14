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
                        class="px-4 py-2.5 pr-10 text-sm border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 hover:border-gray-300 dark:hover:border-gray-600 transition-colors cursor-pointer font-medium appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 20 20%27%3E%3Cpath stroke=%27%236B7280%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%271.5%27 d=%27m6 8 4 4 4-4%27/%3E%3C/svg%3E')] bg-[length:1.25rem] bg-[center_right_0.5rem] bg-no-repeat">
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
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 sm:p-5">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-green-100 dark:bg-green-900/20 rounded-lg flex items-center justify-center">
                        <i class="bx bx-dollar text-xl text-green-600 dark:text-green-400"></i>
                    </div>
                    <div class="flex items-center text-xs text-green-600 dark:text-green-400">
                        <i class="bx bx-trending-up mr-1"></i>
                        <span>+12.5%</span>
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Total Revenue</p>
                <p class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($stats['total_revenue'], 2) }}</p>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 sm:p-5">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/20 rounded-lg flex items-center justify-center">
                        <i class="bx bx-calendar text-xl text-blue-600 dark:text-blue-400"></i>
                    </div>
                    <div class="flex items-center text-xs text-blue-600 dark:text-blue-400">
                        <i class="bx bx-trending-up mr-1"></i>
                        <span>+8.3%</span>
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Period Revenue</p>
                <p class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">${{ number_format($stats['period_revenue'], 2) }}</p>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 sm:p-5">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-purple-100 dark:bg-purple-900/20 rounded-lg flex items-center justify-center">
                        <i class="bx bx-receipt text-xl text-purple-600 dark:text-purple-400"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Total Payments</p>
                <p class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white">{{ number_format($stats['total_payments']) }}</p>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4 sm:p-5">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-10 h-10 bg-amber-100 dark:bg-amber-900/20 rounded-lg flex items-center justify-center">
                        <i class="bx bx-time text-xl text-amber-600 dark:text-amber-400"></i>
                    </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Pending</p>
                <p class="text-xl sm:text-2xl font-bold text-amber-600 dark:text-amber-400">{{ number_format($stats['pending_payments']) }}</p>
            </div>
        </div>

        <!-- Additional Metrics Row -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-4 mb-6">
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Total Refunded</p>
                        <p class="text-lg sm:text-xl font-bold text-red-600 dark:text-red-400">${{ number_format($stats['refunded_total'], 2) }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">{{ number_format($stats['refunded_count']) }} refunds</p>
                    </div>
                    <div class="w-10 h-10 bg-red-100 dark:bg-red-900/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="bx bx-undo text-xl text-red-600 dark:text-red-400"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Average Transaction</p>
                        <p class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">
                            ${{ $stats['total_payments'] > 0 ? number_format($stats['total_revenue'] / $stats['total_payments'], 2) : '0.00' }}
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Per payment</p>
                    </div>
                    <div class="w-10 h-10 bg-indigo-100 dark:bg-indigo-900/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="bx bx-bar-chart text-xl text-indigo-600 dark:text-indigo-400"></i>
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <p class="text-xs text-gray-500 dark:text-gray-400 mb-1">Success Rate</p>
                        <p class="text-lg sm:text-xl font-bold text-gray-900 dark:text-white">
                            {{ $stats['total_payments'] > 0 ? number_format((($stats['total_payments'] - $stats['pending_payments']) / $stats['total_payments']) * 100, 1) : '0' }}%
                        </p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 mt-1">Completed payments</p>
                    </div>
                    <div class="w-10 h-10 bg-emerald-100 dark:bg-emerald-900/20 rounded-lg flex items-center justify-center flex-shrink-0">
                        <i class="bx bx-check-circle text-xl text-emerald-600 dark:text-emerald-400"></i>
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
                                        <button onclick="refundPayment('{{ route('api.admin.payments.refund', $payment) }}', this.closest('tr'))" class="text-red-600 dark:text-red-400 hover:text-red-700 text-sm font-medium">Refund</button>
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

@section('scripts')
<script>
function refundPayment(url, rowElement) {
    showConfirmToast('Are you sure you want to refund this payment?', function() {
        performRefund(url, rowElement);
    });
}

function performRefund(url, rowElement) {
    fetch(url, {
        method: 'PATCH',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success || data.message) {
            const statusCell = rowElement.querySelector('td:nth-child(3) span');
            statusCell.className = 'px-2 py-1 text-xs font-medium rounded bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-400';
            statusCell.textContent = 'Refunded';
            
            const actionCell = rowElement.querySelector('td:last-child');
            actionCell.innerHTML = '<span class="text-gray-400 text-sm">-</span>';
            
            showToast('Payment refunded successfully', 'success');
        } else {
            showToast(data.message || 'Failed to refund payment', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showToast('An error occurred while processing refund', 'error');
    });
}

function showConfirmToast(message, onConfirm) {
    const toastContainer = document.createElement('div');
    toastContainer.className = 'fixed bottom-20 right-4 bg-amber-500 text-white px-6 py-4 rounded-lg shadow-lg z-50 flex items-center gap-4 animate-slide-in max-w-md';
    
    toastContainer.innerHTML = `
        <div class="flex items-center gap-3 flex-1">
            <i class="bx bx-info-circle text-lg flex-shrink-0"></i>
            <span class="text-sm font-medium">${message}</span>
        </div>
        <div class="flex gap-2 flex-shrink-0">
            <button onclick="this.closest('[data-toast]').remove(); (${onConfirm.toString()})()" class="px-4 py-1.5 bg-white/20 hover:bg-white/30 rounded text-xs font-semibold transition-colors whitespace-nowrap">Confirm</button>
            <button onclick="this.closest('[data-toast]').remove()" class="px-4 py-1.5 bg-white/10 hover:bg-white/20 rounded text-xs font-semibold transition-colors whitespace-nowrap">Cancel</button>
        </div>
    `;
    toastContainer.setAttribute('data-toast', 'true');
    
    document.body.appendChild(toastContainer);
}

function showToast(message, type = 'info', duration = 3000) {
    const bgColor = type === 'success' ? 'bg-green-500' : type === 'error' ? 'bg-red-500' : 'bg-blue-500';
    const icon = type === 'success' ? 'bx-check-circle' : type === 'error' ? 'bx-error-circle' : 'bx-bell';
    
    const toast = document.createElement('div');
    toast.className = `fixed bottom-20 right-4 ${bgColor} text-white px-6 py-4 rounded-lg shadow-lg z-50 flex items-center gap-3 animate-slide-in`;
    toast.setAttribute('data-toast', 'true');
    
    toast.innerHTML = `
        <i class="bx ${icon} text-lg flex-shrink-0"></i>
        <span class="text-sm font-medium">${message}</span>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.style.transition = 'opacity 0.3s ease-out';
        toast.style.opacity = '0';
        setTimeout(() => toast.remove(), 300);
    }, duration);
}

const style = document.createElement('style');
style.textContent = `
    @keyframes slide-in {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    .animate-slide-in {
        animation: slide-in 0.3s ease-out;
    }
`;
document.head.appendChild(style);
</script>
@endsection
