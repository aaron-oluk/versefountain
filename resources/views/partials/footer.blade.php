<footer class="bg-white dark:bg-gray-900 text-gray-700 dark:text-gray-300 border-t border-gray-200 dark:border-gray-800 py-12 sm:py-16 mt-16 sm:mt-20 md:pl-56">
    <div class="px-4 sm:px-6 lg:px-8">
        <!-- Main Footer Content -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 sm:gap-12 mb-8 sm:mb-12 pb-8 sm:pb-12 border-b border-gray-200 dark:border-gray-800">
            <!-- About VerseFountain -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">About VerseFountain</h3>
                <p class="text-sm leading-relaxed text-gray-600 dark:text-gray-400">Your premier platform for literature, poetry, and academic excellence. Connect with readers and writers worldwide.</p>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Quick Links</h3>
                <ul class="space-y-3 text-sm">
                    <li>
                        <a href="{{ route('books.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Library</a>
                    </li>
                    <li>
                        <a href="{{ route('poetry.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Poetry</a>
                    </li>
                    <li>
                        <a href="{{ route('events.index') }}" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Events</a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Premium</a>
                    </li>
                </ul>
            </div>

            <!-- Legal -->
            <div>
                <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Legal</h3>
                <ul class="space-y-3 text-sm">
                    <li>
                        <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Privacy Policy</a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Terms of Service</a>
                    </li>
                    <li>
                        <a href="{{ route('refund-cancellation-policies') }}" class="text-gray-600 dark:text-gray-400 hover:text-blue-600 dark:hover:text-blue-400 transition-colors">Refund & Cancellation</a>
                    </li>
                </ul>
            </div>
        </div>

        <!-- Copyright -->
        <div class="text-center text-sm text-gray-500 dark:text-gray-600">
            <p>&copy; 2026 VerseFountain. All rights reserved.</p>
        </div>
    </div>
</footer>
