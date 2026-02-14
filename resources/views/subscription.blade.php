@extends('layouts.app')

@section('title', 'Subscription - VerseFountain')
@section('content')
    <div class="min-h-screen bg-gray-50 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <!-- Hero Section -->
            <div class="text-center mb-12">
                <h1 class="text-4xl font-semibold text-gray-900 dark:text-white mb-2">
                    Support Creators & <span class="text-blue-600">Read</span> <span class="text-blue-600">Without
                        Limits</span>
                </h1>
                <p class="text-base text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    Choose a plan that fits your reading style. Your subscription directly helps sustain the arts and the
                    poets you love.
                </p>
            </div>

            <!-- Plan Toggle -->
            <div class="flex justify-center mb-8">
                <div class="inline-flex bg-gray-200 dark:bg-gray-700 rounded-lg p-1">
                    <button onclick="toggleBilling('monthly')" id="monthly-btn"
                        class="monthly-btn px-6 py-2 bg-white dark:bg-gray-800 text-gray-900 dark:text-white text-sm font-medium rounded-lg shadow-sm transition-all">
                        Monthly
                    </button>
                    <button onclick="toggleBilling('yearly')" id="yearly-btn"
                        class="yearly-btn px-6 py-2 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg relative transition-all">
                        Yearly
                        <span
                            class="absolute -top-2 -right-2 px-2 py-0.5 bg-blue-600 text-white text-xs font-semibold rounded-full">SAVE
                            20%</span>
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
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Perfect for casual readers exploring classics.
                    </p>
                    <button
                        class="w-full px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg mb-6"
                        disabled>
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
                    </ul>
                </div>

                <!-- Avid Reader Plan -->
                <div class="bg-white dark:bg-gray-800 rounded-lg border-2 border-blue-600 p-6 relative">
                    <div
                        class="absolute top-0 left-0 right-0 bg-blue-600 text-white text-center py-1 text-xs font-semibold rounded-t-lg">
                        MOST POPULAR
                    </div>
                    <div class="pt-6">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Avid Reader</h3>
                        <div class="mb-1">
                            <p class="text-2xl font-bold text-gray-900 dark:text-white monthly-price"
                                style="display: block;">$9.99</p>
                            <p class="text-2xl font-bold text-gray-900 dark:text-white yearly-price" style="display: none;">
                                $95.88</p>
                        </div>
                        <div class="mb-4">
                            <p class="text-sm text-gray-600 dark:text-gray-400 monthly-period" style="display: block;">
                                /month</p>
                            <p class="text-sm text-gray-600 dark:text-gray-400 yearly-period" style="display: none;">/year
                                (save $24)</p>
                        </div>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">For those who breathe poetry daily.</p>
                        <button
                            class="w-full px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg mb-6 hover:bg-blue-700 transition-colors">
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
                            <li class="flex items-center text-sm text-gray-400 dark:text-gray-500">
                                <i class="bx bx-x text-gray-300 mr-2"></i>
                                Direct creator messaging
                            </li>
                        </ul>
                    </div>
                </div>

                <!-- Literary Patron Plan -->
                <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-6 relative">
                    <div
                        class="absolute top-4 right-4 bg-gray-800 dark:bg-gray-700 text-white px-2 py-1 text-xs font-semibold rounded">
                        BEST VALUE
                    </div>
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">Literary Patron</h3>
                    <div class="mb-1">
                        <p class="text-2xl font-bold text-gray-900 dark:text-white monthly-price" style="display: block;">
                            $19.99</p>
                        <p class="text-2xl font-bold text-gray-900 dark:text-white yearly-price" style="display: none;">
                            $191.88</p>
                    </div>
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 dark:text-gray-400 monthly-period" style="display: block;">/month
                        </p>
                        <p class="text-sm text-gray-600 dark:text-gray-400 yearly-period" style="display: none;">/year (save
                            $48)</p>
                    </div>
                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">Directly support the poets you love.</p>
                    <button
                        class="w-full px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-300 text-sm font-medium rounded-lg mb-6 hover:bg-gray-300 dark:hover:bg-gray-600 transition-colors">
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
            <!-- Features Comparison Section -->
            <div class="bg-white dark:bg-gray-800 rounded-2xl border border-gray-200 dark:border-gray-700 p-8 mb-12">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-8 text-center">Compare Features</h2>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 dark:border-gray-700">
                                <th class="text-left py-4 px-4 font-semibold text-gray-900 dark:text-white">Feature
                                </th>
                                <th class="text-center py-4 px-4 font-semibold text-gray-900 dark:text-white">Wanderer
                                </th>
                                <th class="text-center py-4 px-4 font-semibold text-gray-900 dark:text-white">Avid
                                    Reader
                                </th>
                                <th class="text-center py-4 px-4 font-semibold text-gray-900 dark:text-white">Literary
                                    Patron</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr
                                class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="py-4 px-4 text-gray-700 dark:text-gray-300">Library Access</td>
                                <td class="text-center"><i class="bx bx-check text-green-600 text-lg"></i></td>
                                <td class="text-center"><i class="bx bx-check text-green-600 text-lg"></i></td>
                                <td class="text-center"><i class="bx bx-check text-green-600 text-lg"></i></td>
                            </tr>
                            <tr
                                class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="py-4 px-4 text-gray-700 dark:text-gray-300">Chatroom Access</td>
                                <td class="text-center"><span class="text-sm font-semibold text-gray-600">1</span>
                                </td>
                                <td class="text-center"><span class="text-sm font-semibold text-gray-600">5</span>
                                </td>
                                <td class="text-center"><span class="text-sm font-semibold text-gray-600">Unlimited</span>
                                </td>
                            </tr>
                            <tr
                                class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="py-4 px-4 text-gray-700 dark:text-gray-300">Offline Reading</td>
                                <td class="text-center"><i class="bx bx-x text-gray-300 text-lg"></i></td>
                                <td class="text-center"><i class="bx bx-check text-green-600 text-lg"></i></td>
                                <td class="text-center"><i class="bx bx-check text-green-600 text-lg"></i></td>
                            </tr>
                            <tr
                                class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="py-4 px-4 text-gray-700 dark:text-gray-300">Creator Messaging</td>
                                <td class="text-center"><i class="bx bx-x text-gray-300 text-lg"></i></td>
                                <td class="text-center"><i class="bx bx-x text-gray-300 text-lg"></i></td>
                                <td class="text-center"><i class="bx bx-check text-green-600 text-lg"></i></td>
                            </tr>
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50">
                                <td class="py-4 px-4 text-gray-700 dark:text-gray-300">Ad-Free Reading</td>
                                <td class="text-center"><i class="bx bx-x text-gray-300 text-lg"></i></td>
                                <td class="text-center"><i class="bx bx-check text-green-600 text-lg"></i></td>
                                <td class="text-center"><i class="bx bx-check text-green-600 text-lg"></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <!-- FAQ Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
                <div>
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white mb-6">Frequently Asked Questions</h2>
                    <div class="space-y-4">
                        <details
                            class="group bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 hover:border-blue-400 dark:hover:border-blue-500 cursor-pointer">
                            <summary class="flex justify-between items-center font-semibold text-gray-900 dark:text-white">
                                Can I change my plan later?
                                <i class="bx bx-chevron-down group-open:rotate-180 transition-transform"></i>
                            </summary>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-3">Yes! You can upgrade or downgrade your
                                plan anytime. Changes take effect on your next billing cycle.</p>
                        </details>
                        <details
                            class="group bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 hover:border-blue-400 dark:hover:border-blue-500 cursor-pointer">
                            <summary class="flex justify-between items-center font-semibold text-gray-900 dark:text-white">
                                How does creator support work?
                                <i class="bx bx-chevron-down group-open:rotate-180 transition-transform"></i>
                            </summary>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-3">A portion of your subscription is
                                distributed to creators you follow. Patrons can directly support creators through special
                                features.</p>
                        </details>
                        <details
                            class="group bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4 hover:border-blue-400 dark:hover:border-blue-500 cursor-pointer">
                            <summary class="flex justify-between items-center font-semibold text-gray-900 dark:text-white">
                                Is there a free trial?
                                <i class="bx bx-chevron-down group-open:rotate-180 transition-transform"></i>
                            </summary>
                            <p class="text-gray-600 dark:text-gray-400 text-sm mt-3">Yes! New subscribers get 7 days free.
                                No credit card required to try Avid Reader or Literary Patron plans.</p>
                        </details>
                    </div>
                </div>
                <div
                    class="bg-gradient-to-br from-blue-50 to-purple-50 dark:from-blue-900/20 dark:to-purple-900/20 rounded-2xl p-8 border border-blue-200 dark:border-blue-800">
                    <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-6">Why Subscribe?</h3>
                    <ul class="space-y-4">
                        <li class="flex items-start gap-4">
                            <div
                                class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="bx bx-check text-white text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">Support Your Favorite Creators</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Your subscription directly funds
                                    poets and authors you love</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div
                                class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="bx bx-check text-white text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">Access Exclusive Content</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Get early access to new works and
                                    special patron-only pieces</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div
                                class="w-8 h-8 bg-blue-600 rounded-full flex items-center justify-center flex-shrink-0 mt-0.5">
                                <i class="bx bx-check text-white text-lg"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 dark:text-white">Premium Experience</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Enjoy ad-free reading, offline
                                    mode, and exclusive features</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
<script>
    function toggleBilling(period) {
        const monthlyBtn = document.getElementById('monthly-btn');
        const yearlyBtn = document.getElementById('yearly-btn');
        const monthlyPrices = document.querySelectorAll('.monthly-price');
        const yearlyPrices = document.querySelectorAll('.yearly-price');
        const monthlyPeriods = document.querySelectorAll('.monthly-period');
        const yearlyPeriods = document.querySelectorAll('.yearly-period');
        const monthlySummary = document.querySelectorAll('.monthly-summary');
        const yearlySummary = document.querySelectorAll('.yearly-summary');
        const monthlyTax = document.querySelectorAll('.monthly-tax');
        const yearlyTax = document.querySelectorAll('.yearly-tax');
        const monthlyTotal = document.querySelectorAll('.monthly-total');
        const yearlyTotal = document.querySelectorAll('.yearly-total');

        if (period === 'monthly') {
            monthlyBtn.classList.add('bg-white', 'dark:bg-gray-800', 'shadow-sm', 'text-gray-900', 'dark:text-white');
            yearlyBtn.classList.remove('bg-white', 'dark:bg-gray-800', 'shadow-sm', 'text-gray-900', 'dark:text-white');
            yearlyBtn.classList.add('text-gray-700', 'dark:text-gray-300');
            monthlyBtn.classList.remove('text-gray-700', 'dark:text-gray-300');

            monthlyPrices.forEach(el => el.style.display = 'block');
            yearlyPrices.forEach(el => el.style.display = 'none');
            monthlyPeriods.forEach(el => el.style.display = 'block');
            yearlyPeriods.forEach(el => el.style.display = 'none');
            monthlySummary.forEach(el => el.style.display = 'flex');
            yearlySummary.forEach(el => el.style.display = 'none');
            monthlyTax.forEach(el => el.style.display = 'block');
            yearlyTax.forEach(el => el.style.display = 'none');
            monthlyTotal.forEach(el => el.style.display = 'block');
            yearlyTotal.forEach(el => el.style.display = 'none');
        } else {
            yearlyBtn.classList.add('bg-white', 'dark:bg-gray-800', 'shadow-sm', 'text-gray-900', 'dark:text-white');
            monthlyBtn.classList.remove('bg-white', 'dark:bg-gray-800', 'shadow-sm', 'text-gray-900',
                'dark:text-white');
            monthlyBtn.classList.add('text-gray-700', 'dark:text-gray-300');
            yearlyBtn.classList.remove('text-gray-700', 'dark:text-gray-300');

            monthlyPrices.forEach(el => el.style.display = 'none');
            yearlyPrices.forEach(el => el.style.display = 'block');
            monthlyPeriods.forEach(el => el.style.display = 'none');
            yearlyPeriods.forEach(el => el.style.display = 'block');
            monthlySummary.forEach(el => el.style.display = 'none');
            yearlySummary.forEach(el => el.style.display = 'flex');
            monthlyTax.forEach(el => el.style.display = 'none');
            yearlyTax.forEach(el => el.style.display = 'block');
            monthlyTotal.forEach(el => el.style.display = 'none');
            yearlyTotal.forEach(el => el.style.display = 'block');
        }
    }
</script>
