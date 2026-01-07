<!-- Mobile Bottom Navigation -->
<nav class="md:hidden fixed bottom-0 left-0 right-0 bg-white border-t border-gray-200 z-50">
    <div class="flex justify-around py-2 px-2">
        <a href="{{ auth()->check() ? route('dashboard') : url('/') }}" class="flex flex-col items-center py-2 px-3 rounded-lg transition-colors {{ request()->routeIs('dashboard') || request()->is('/') ? 'text-blue-600' : 'text-gray-400' }}">
            <i class="bx bx-home-alt text-xl mb-0.5"></i>
            <span class="text-[10px] font-medium">Home</span>
        </a>
        <a href="{{ route('books.index') }}" class="flex flex-col items-center py-2 px-3 rounded-lg transition-colors {{ request()->routeIs('books.*') ? 'text-blue-600' : 'text-gray-400' }}">
            <i class="bx bx-library text-xl mb-0.5"></i>
            <span class="text-[10px] font-medium">Library</span>
        </a>
        @auth
            <a href="{{ route('chatrooms.index') }}" class="flex flex-col items-center py-2 px-3 rounded-lg transition-colors {{ request()->routeIs('chatrooms.*') || request()->routeIs('chatroom.*') ? 'text-blue-600' : 'text-gray-400' }}">
                <i class="bx bx-message-square-dots text-xl mb-0.5"></i>
                <span class="text-[10px] font-medium">Chat</span>
            </a>
        @endauth
        <a href="{{ route('creators.index') }}" class="flex flex-col items-center py-2 px-3 rounded-lg transition-colors {{ request()->routeIs('creators.*') ? 'text-blue-600' : 'text-gray-400' }}">
            <i class="bx bx-user-circle text-xl mb-0.5"></i>
            <span class="text-[10px] font-medium">Creators</span>
        </a>
        @auth
            <a href="{{ route('profile') }}" class="flex flex-col items-center py-2 px-3 rounded-lg transition-colors {{ request()->routeIs('profile') ? 'text-blue-600' : 'text-gray-400' }}">
                <i class="bx bx-user text-xl mb-0.5"></i>
                <span class="text-[10px] font-medium">Profile</span>
            </a>
        @else
            <a href="{{ route('login') }}" class="flex flex-col items-center py-2 px-3 rounded-lg transition-colors text-gray-400">
                <i class="bx bx-log-in text-xl mb-0.5"></i>
                <span class="text-[10px] font-medium">Login</span>
            </a>
        @endauth
    </div>
</nav>
