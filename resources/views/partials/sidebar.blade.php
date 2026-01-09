<!-- Desktop Sidebar Navigation -->
<div
    class="hidden md:flex md:flex-col md:w-56 md:fixed md:inset-y-0 md:bg-white dark:md:bg-gray-900 md:border-r md:border-gray-200 dark:md:border-gray-800 md:z-30">
    <!-- Logo -->
    <div class="px-5 py-5 border-b border-gray-100 dark:border-gray-800">
        <a href="{{ route('dashboard') }}" class="flex items-center space-x-2">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center">
                <i class="bx bx-book-open text-white text-base"></i>
            </div>
            <div>
                <span class="text-base font-bold text-gray-900 dark:text-white">VerseFountain</span>
                <p class="text-[10px] text-gray-500 dark:text-gray-400 -mt-0.5">Your Reading Sanctuary</p>
            </div>
        </a>
    </div>

    <!-- Navigation Menu -->
    <div class="flex-1 flex flex-col min-h-0 overflow-y-auto sidebar-scroll">
        <nav class="flex-1 px-3 py-4">
            <div class="space-y-0.5">
                <a href="{{ auth()->check() ? route('dashboard') : url('/') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('dashboard') || request()->is('/') ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                    <i
                        class="bx bx-home-alt mr-3 text-lg {{ request()->routeIs('dashboard') || request()->is('/') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                    Home
                </a>

                <a href="{{ route('books.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('books.*') && !request()->routeIs('books.read') ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                    <i
                        class="bx bx-library mr-3 text-lg {{ request()->routeIs('books.*') && !request()->routeIs('books.read') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                    Library
                </a>

                <a href="{{ route('poetry.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('poetry.*') ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                    <i
                        class="bx bx-pen mr-3 text-lg {{ request()->routeIs('poetry.*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                    Poetry
                </a>

                @auth
                    <!-- Chatrooms Main -->
                    <a href="{{ route('chatrooms.index') }}"
                        class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('chatrooms.*') || request()->routeIs('chatroom.*') ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                        <i
                            class="bx bx-message-square-dots mr-3 text-lg {{ request()->routeIs('chatrooms.*') || request()->routeIs('chatroom.*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                        Chatrooms
                    </a>

                    <!-- Chatroom Sub-items (Nested with smaller indent) -->
                    <div class="ml-6 space-y-0.5 border-l border-gray-200 dark:border-gray-700 pl-2">
                        <a href="{{ route('chatrooms.index', ['filter' => 'invites']) }}"
                            class="flex items-center px-3 py-1.5 text-xs font-medium rounded-lg transition-colors {{ request('filter') === 'invites' ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                            <i class="bx bx-envelope mr-2 text-base"></i>
                            Invites
                        </a>

                        <a href="{{ route('chatrooms.my') }}"
                            class="flex items-center px-3 py-1.5 text-xs font-medium rounded-lg transition-colors {{ request()->routeIs('chatrooms.my') ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                            <i class="bx bx-chat mr-2 text-base"></i>
                            My Rooms
                        </a>

                        <a href="{{ route('chatrooms.index', ['filter' => 'poetry-slams']) }}"
                            class="flex items-center px-3 py-1.5 text-xs font-medium rounded-lg transition-colors {{ request('filter') === 'poetry-slams' ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                            <i class="bx bx-microphone mr-2 text-base"></i>
                            Poetry Slams
                        </a>

                        <a href="{{ route('chatrooms.index', ['filter' => 'book-clubs']) }}"
                            class="flex items-center px-3 py-1.5 text-xs font-medium rounded-lg transition-colors {{ request('filter') === 'book-clubs' ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                            <i class="bx bx-book mr-2 text-base"></i>
                            Book Clubs
                        </a>

                        <a href="{{ route('chatrooms.index', ['filter' => 'author-qa']) }}"
                            class="flex items-center px-3 py-1.5 text-xs font-medium rounded-lg transition-colors {{ request('filter') === 'author-qa' ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : 'text-gray-500 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                            <i class="bx bx-help-circle mr-2 text-base"></i>
                            Author Q&A
                        </a>
                    </div>
                @endauth

                <a href="{{ route('creators.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('creators.*') || request()->routeIs('profile.creator') ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                    <i
                        class="bx bx-user-circle mr-3 text-lg {{ request()->routeIs('creators.*') || request()->routeIs('profile.creator') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                    Creators
                </a>

                <a href="{{ route('community') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('community') ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                    <i
                        class="bx bx-group mr-3 text-lg {{ request()->routeIs('community') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                    Community
                </a>

                <a href="{{ route('events.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('events.*') ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                    <i
                        class="bx bx-calendar-event mr-3 text-lg {{ request()->routeIs('events.*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                    Events
                </a>

                @auth
                    <a href="{{ route('tickets.index') }}"
                        class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('tickets.*') ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                        <i
                            class="bx bx-receipt mr-3 text-lg {{ request()->routeIs('tickets.*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                        My Tickets
                    </a>
                @endauth

                <a href="/academics"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->is('academics*') ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                    <i
                        class="bx bx-book-bookmark mr-3 text-lg {{ request()->is('academics*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                    Resources
                </a>

                @if(!auth()->check() || auth()->user()->role !== 'admin')
                    <a href="{{ route('subscription') }}"
                        class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('subscription') ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                        <i
                            class="bx bx-diamond mr-3 text-lg {{ request()->routeIs('subscription') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                        Subscription
                    </a>
                @endif

                @auth
                    @if(auth()->user()->role === 'admin')
                        <!-- Admin Section -->
                        <div class="pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">
                            <p class="px-3 mb-2 text-xs font-semibold text-gray-400 dark:text-gray-500 uppercase tracking-wider">Admin</p>

                            <a href="{{ route('admin.dashboard') }}"
                                class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                                <i class="bx bx-tachometer mr-3 text-lg {{ request()->routeIs('admin.dashboard') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                                Dashboard
                            </a>

                            <a href="{{ route('admin.users') }}"
                                class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.users*') ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                                <i class="bx bx-user mr-3 text-lg {{ request()->routeIs('admin.users*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                                Users
                            </a>

                            <a href="{{ route('admin.subscriptions') }}"
                                class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.subscriptions*') ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                                <i class="bx bx-credit-card mr-3 text-lg {{ request()->routeIs('admin.subscriptions*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                                Subscriptions
                            </a>

                            <a href="{{ route('admin.finances') }}"
                                class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.finances*') ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                                <i class="bx bx-dollar-circle mr-3 text-lg {{ request()->routeIs('admin.finances*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                                Finances
                            </a>

                            <a href="{{ route('admin.reports') }}"
                                class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ request()->routeIs('admin.reports*') ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800' }}">
                                <i class="bx bx-bar-chart-alt-2 mr-3 text-lg {{ request()->routeIs('admin.reports*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                                Reports & Analytics
                            </a>
                        </div>
                    @endif
                @endauth
            </div>
        </nav>

        <!-- Bottom Section -->
        <div class="px-3 pb-4 mt-auto">
            @auth
                <!-- Settings -->
                <a href="{{ route('settings.index') }}"
                    class="flex items-center px-3 py-2 text-sm font-medium rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors mb-3 {{ request()->routeIs('settings.*') ? 'bg-blue-50 dark:bg-gray-800 text-blue-700 dark:text-blue-400' : '' }}">
                    <i
                        class="bx bx-cog mr-3 text-lg {{ request()->routeIs('settings.*') ? 'text-blue-600 dark:text-blue-400' : 'text-gray-400 dark:text-gray-500' }}"></i>
                    Settings
                </a>

                <!-- User Profile -->
                <a href="{{ route('profile') }}"
                    class="flex items-center gap-3 px-3 py-2 border-t border-gray-100 dark:border-gray-800 pt-4 hover:bg-gray-50 dark:hover:bg-gray-800 rounded-lg transition-colors">
                    <div
                        class="w-9 h-9 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-medium">
                        {{ strtoupper(substr(auth()->user()->first_name ?? (auth()->user()->username ?? 'U'), 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium text-gray-900 dark:text-white truncate">
                            {{ auth()->user()->first_name ?? auth()->user()->username }}</p>
                        <p class="text-xs text-gray-500 dark:text-gray-400 truncate">
                            {{ auth()->user()->role === 'admin' ? 'Administrator' : 'Member' }}</p>
                    </div>
                </a>
            @else
                <div class="border-t border-gray-100 dark:border-gray-800 pt-4 space-y-2">
                    <a href="{{ route('login') }}"
                        class="flex items-center justify-center px-3 py-2 text-sm font-medium rounded-lg text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                        Log In
                    </a>
                    <a href="{{ route('register') }}"
                        class="flex items-center justify-center px-3 py-2 text-sm font-medium rounded-lg bg-blue-600 text-white hover:bg-blue-700 transition-colors">
                        Sign Up
                    </a>
                </div>
            @endauth
        </div>
    </div>
</div>
