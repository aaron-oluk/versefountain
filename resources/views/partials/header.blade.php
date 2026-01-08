@php
    $pageTitle = $pageTitle ?? 'Dashboard';
@endphp

<!-- Top Header Bar -->
<header class="bg-white border-b border-gray-200 fixed top-0 left-0 right-0 md:left-56 z-40">
    <div class="px-4 sm:px-6 lg:px-8 flex items-center justify-between h-14">
        <!-- Page Title -->
        <div class="flex items-center">
            <h1 class="text-base font-semibold text-gray-900">{{ $pageTitle }}</h1>
        </div>

        <!-- Search Bar (Centered) -->
        <div class="flex-1 max-w-lg mx-8 hidden sm:block">
            <form action="{{ route('search') }}" method="GET">
                <div class="relative">
                    <i class="bx bx-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-lg"></i>
                    <input type="text" name="q" placeholder="Search books, authors, or poems..."
                           value="{{ request('q') }}"
                           class="w-full pl-10 pr-4 py-2 bg-gray-50 border border-gray-200 rounded-full focus:border-blue-500 focus:bg-white focus:outline-none text-sm placeholder-gray-400">
                </div>
            </form>
        </div>

        <!-- Right Side Actions -->
        <div class="flex items-center space-x-2">
            @auth
                <!-- Notifications -->
                <button class="relative p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-50 rounded-lg transition-colors">
                    <i class="bx bx-bell text-xl"></i>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>

                <!-- User Dropdown -->
                <div class="relative" data-dropdown>
                    <button data-dropdown-toggle class="flex items-center space-x-2 p-1.5 rounded-lg hover:bg-gray-50 transition-colors">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                            {{ strtoupper(substr(auth()->user()->first_name ?? auth()->user()->username ?? 'U', 0, 1)) }}
                        </div>
                        <i class="bx bx-chevron-down text-gray-400"></i>
                    </button>
                    <div data-dropdown-menu style="display: none;"
                         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                        <a href="{{ route('profile') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            <i class="bx bx-user mr-2"></i> Profile
                        </a>
                        <a href="{{ route('settings.index') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                            <i class="bx bx-cog mr-2"></i> Settings
                        </a>
                        @if(auth()->user()->role === 'admin')
                            <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-50">
                                <i class="bx bx-shield mr-2"></i> Admin
                            </a>
                        @endif
                        <hr class="my-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-50">
                                <i class="bx bx-log-out mr-2"></i> Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <!-- Login/Signup Buttons -->
                <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 px-3 py-2 rounded-lg hover:bg-gray-50 transition-colors">
                    Log In
                </a>
                <a href="{{ route('register') }}" class="bg-blue-600 text-white px-4 py-2 text-sm font-medium hover:bg-blue-700 rounded-lg transition-colors">
                    Sign Up
                </a>
            @endauth
        </div>
    </div>
</header>
