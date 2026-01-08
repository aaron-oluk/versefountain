@extends('layouts.app')

@section('title', 'Subscription - VerseFountain')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Hero Section -->
        <div class="text-center mb-12">
            <h1 class="text-4xl font-semibold text-gray-900 dark:text-white mb-2">
                Support Creators & <span class="text-blue-600">Read</span> <span class="text-blue-600">Without Limits</span>
            </h1>
            <p class="text-base text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                Choose a plan that fits your reading style. Your subscription directly helps sustain the arts and the poets you love.
            </p>
        </div>

        <!-- Plan Toggle -->
        <div class="flex justify-center mb-8">
            <div class="inline-flex bg-gray-200 dark:bg-gray-700 rounded-lg p-1">
                <button class="px-6 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm font-medium rounded-lg shadow-sm">
                    Monthly
                </button>
                <button class="px-6 py-2 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg relative">
                    Yearly
                    <span class="absolute -top-2 -right-2 px-2 py-0.5 bg-blue-600 text-white text-xs font-semibold rounded-full">SAVE 20%</span>
                </button>
            </div>
        </div>

        <!-- Subscription Plans -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <!-- Wanderer Plan -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Wanderer</h3>
                <p class="text-2xl font-bold text-gray-900 dark:text-white mb-1">Free</p>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">/forever</p>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Perfect for casual readers exploring classics.</p>
                <button class="w-full px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg mb-6" disabled>
                    Current Plan
                </button>
                <ul class="space-y-3">
                    <li class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                        <i class="bx bx-check text-green-600 mr-2"></i>
                        Access to public domain classics
                    </li>
                    <li class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                        <i class="bx bx-check text-green-600 mr-2"></i>
                        Join 1 community chatroom
                    </li>
                    <li class="flex items-center text-sm text-gray-400 dark:text-gray-500">
                        <i class="bx bx-x text-gray-300 mr-2"></i>
                        Offline reading mode
                    </li>
                </ul>
            </div>

            <!-- Avid Reader Plan -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border-2 border-blue-600 p-6 relative">
                <div class="absolute top-0 left-0 right-0 bg-blue-600 text-white text-center py-1 text-xs font-semibold rounded-t-lg">
                    MOST POPULAR
                </div>
                <div class="pt-6">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Avid Reader</h3>
                    <p class="text-2xl font-bold text-gray-900 dark:text-white mb-1">$9.99</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">/month</p>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">For those who breathe poetry daily.</p>
                    <button class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg mb-6 hover:bg-blue-700 transition-colors">
                        Select Reader
                    </button>
                    <ul class="space-y-3">
                        <li class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                            <i class="bx bx-check text-green-600 mr-2"></i>
                            Unlimited library access
                        </li>
                        <li class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                            <i class="bx bx-check text-green-600 mr-2"></i>
                            Join 5 chatrooms
                        </li>
                        <li class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                            <i class="bx bx-check text-green-600 mr-2"></i>
                            Offline reading mode
                        </li>
                        <li class="flex items-center text-sm text-gray-400 dark:text-gray-500">
                            <i class="bx bx-x text-gray-300 mr-2"></i>
                            Direct creator messaging
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Literary Patron Plan -->
            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 relative">
                <div class="absolute top-4 right-4 bg-gray-800 dark:bg-gray-700 text-white px-2 py-1 text-xs font-semibold rounded">
                    BEST VALUE
                </div>
                <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Literary Patron</h3>
                <p class="text-2xl font-bold text-gray-900 dark:text-white mb-1">$19.99</p>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">/month</p>
                <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Directly support the poets you love.</p>
                <button class="w-full px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg mb-6 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
                    Select Patron
                </button>
                <ul class="space-y-3">
                    <li class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                        <i class="bx bx-check text-green-600 mr-2"></i>
                        All Reader features included
                    </li>
                    <li class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                        <i class="bx bx-check text-green-600 mr-2"></i>
                        Direct creator messaging
                    </li>
                    <li class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                        <i class="bx bx-check text-green-600 mr-2"></i>
                        Exclusive early-access content
                    </li>
                    <li class="flex items-center text-sm text-gray-700 dark:text-gray-300">
                        <i class="bx bx-check text-green-600 mr-2"></i>
                        "Patron" Profile Badge
                    </li>
                </ul>
            </div>
        </div>

        <!-- Complete Subscription Section -->
        <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-8">
            <div class="flex items-center gap-2 mb-6">
                <i class="bx bx-lock text-blue-600"></i>
                <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Complete Your Subscription</h2>
            </div>
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Payment Method -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase mb-4">Payment Method</h3>
                    <div class="flex gap-2 mb-6 border-b border-gray-200 dark:border-gray-700">
                        <button class="px-4 py-2 text-sm font-medium text-blue-600 border-b-2 border-blue-600 flex items-center gap-2">
                            <i class="bx bx-credit-card"></i>
                            Card
                        </button>
                        <button class="px-4 py-2 text-sm font-medium text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-200">
                            PayPal
                        </button>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase mb-2">Cardholder Name</label>
                            <input type="text" placeholder="e.g. Jane Doe"
                                   class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase mb-2">Card Number</label>
                            <div class="relative">
                                <input type="text" placeholder="0000 0000 0000 0000"
                                       class="w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                                <i class="bx bx-credit-card absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-500"></i>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase mb-2">Expiration Date</label>
                                <input type="text" placeholder="MM / YY"
                                       class="w-full px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase mb-2">CVC / CVV</label>
                                <div class="relative">
                                    <input type="text" placeholder="123"
                                           class="w-full pl-10 pr-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                                    <i class="bx bx-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-500"></i>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center">
                            <input type="checkbox" id="save-card" class="h-4 w-4 text-blue-600 border-gray-300 dark:border-gray-600 rounded">
                            <label for="save-card" class="ml-2 text-sm text-gray-700 dark:text-gray-300">Save this card for future purchases</label>
                        </div>
                    </div>
                </div>

                <!-- Order Summary -->
                <div>
                    <h3 class="text-sm font-semibold text-gray-900 dark:text-white uppercase mb-4">Order Summary</h3>
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6">
                        <div class="space-y-3 mb-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Avid Reader Plan (Monthly)</span>
                                <span class="font-medium text-gray-900 dark:text-white">$9.99</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Tax (Estimated)</span>
                                <span class="font-medium text-gray-900 dark:text-white">$0.80</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Discount</span>
                                <span class="font-medium text-green-600">$0.00</span>
                            </div>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-600 pt-4 mb-6">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-semibold text-gray-900 dark:text-white">Total due today</span>
                                <span class="text-2xl font-bold text-gray-900 dark:text-white">$10.79</span>
                            </div>
                        </div>
                        <button class="w-full px-6 py-3 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors mb-4">
                            Pay & Subscribe
                        </button>
                        <div class="flex items-center justify-center gap-2 text-xs text-gray-600 dark:text-gray-400">
                            <i class="bx bx-lock"></i>
                            <span>Payments are SSL encrypted and secure.</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

