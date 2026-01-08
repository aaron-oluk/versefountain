<!-- Mobile Bottom Navigation -->
<nav
    class="md:hidden fixed bottom-0 left-0 right-0 bg-white dark:bg-gray-900 border-t border-gray-200 dark:border-gray-800 z-50 safe-area-bottom">
    <div class="flex justify-between items-center py-2 px-4 max-w-lg mx-auto">
        <a href="{{ auth()->check() ? route('dashboard') : url('/') }}"
            class="flex flex-col items-center justify-center min-w-0 flex-1 py-1.5 rounded-lg transition-colors {{ request()->routeIs('dashboard') || request()->is('/') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400' }}">
            <i
                class="bx {{ request()->routeIs('dashboard') || request()->is('/') ? 'bxs-home' : 'bx-home-alt' }} text-[22px]"></i>
            <span class="text-[10px] font-medium mt-0.5">Home</span>
        </a>
        <a href="{{ route('books.index') }}"
            class="flex flex-col items-center justify-center min-w-0 flex-1 py-1.5 rounded-lg transition-colors {{ request()->routeIs('books.*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400' }}">
            <i class="bx {{ request()->routeIs('books.*') ? 'bxs-book-reader' : 'bx-book-reader' }} text-[22px]"></i>
            <span class="text-[10px] font-medium mt-0.5">Library</span>
        </a>
        @auth
            <a href="{{ route('chatrooms.index') }}"
                class="flex flex-col items-center justify-center min-w-0 flex-1 py-1.5 rounded-lg transition-colors {{ request()->routeIs('chatrooms.*') || request()->routeIs('chatroom.*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400' }}">
                <i
                    class="bx {{ request()->routeIs('chatrooms.*') || request()->routeIs('chatroom.*') ? 'bxs-chat' : 'bx-chat' }} text-[22px]"></i>
                <span class="text-[10px] font-medium mt-0.5">Chat</span>
            </a>
        @endauth
        <a href="{{ route('events.index') }}"
            class="flex flex-col items-center justify-center min-w-0 flex-1 py-1.5 rounded-lg transition-colors {{ request()->routeIs('events.*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400' }}">
            <i
                class="bx {{ request()->routeIs('events.*') ? 'bxs-calendar' : 'bx-calendar' }} text-[22px]"></i>
            <span class="text-[10px] font-medium mt-0.5">Events</span>
        </a>
        <a href="/academics"
            class="flex flex-col items-center justify-center min-w-0 flex-1 py-1.5 rounded-lg transition-colors {{ request()->is('academics*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400' }}">
            <i
                class="bx {{ request()->is('academics*') ? 'bxs-book' : 'bx-book' }} text-[22px]"></i>
            <span class="text-[10px] font-medium mt-0.5">Resources</span>
        </a>
        <a href="{{ route('subscription') }}"
            class="flex flex-col items-center justify-center min-w-0 flex-1 py-1.5 rounded-lg transition-colors {{ request()->routeIs('subscription') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400' }}">
            <i
                class="bx {{ request()->routeIs('subscription') ? 'bxs-diamond' : 'bx-diamond' }} text-[22px]"></i>
            <span class="text-[10px] font-medium mt-0.5">Premium</span>
        </a>
        @auth
            <a href="{{ route('profile') }}"
                class="flex flex-col items-center justify-center min-w-0 flex-1 py-1.5 rounded-lg transition-colors {{ request()->routeIs('profile') || request()->routeIs('profile.edit') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400' }}">
                <i
                    class="bx {{ request()->routeIs('profile') || request()->routeIs('profile.edit') ? 'bxs-user' : 'bx-user' }} text-[22px]"></i>
                <span class="text-[10px] font-medium mt-0.5">Profile</span>
            </a>
        @else
            <a href="{{ route('login') }}"
                class="flex flex-col items-center justify-center min-w-0 flex-1 py-1.5 rounded-lg transition-colors text-gray-500 dark:text-gray-400">
                <i class="bx bx-log-in text-[22px]"></i>
                <span class="text-[10px] font-medium mt-0.5">Login</span>
            </a>
        @endauth
    </div>
</nav>
