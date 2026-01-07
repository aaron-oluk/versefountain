<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'VerseFountain'))</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    @yield('head')
</head>

<body class="antialiased bg-gray-50">
    <div class="min-h-screen flex">
        <!-- Left Section - Auth Form -->
        <div class="flex-1 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
            <div class="w-full max-w-md">
                @yield('auth-content')
            </div>
        </div>

        <!-- Right Section - Feature Promotion -->
        @if(request()->routeIs('login') || request()->routeIs('register'))
        <div class="hidden lg:flex lg:flex-1 bg-white items-center justify-center px-12">
            <div class="max-w-md">
                <h2 class="text-3xl font-semibold text-gray-900 mb-4">Discover the World of Poetry</h2>
                <p class="text-base text-gray-600 mb-8">
                    Join our community of readers and writers. Share your poetry, discover new books, and connect with like-minded literature enthusiasts.
                </p>
                <div class="space-y-4">
                    <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="bx bx-edit text-2xl text-gray-600"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-900 mb-1">Share Your Poetry</h3>
                                <p class="text-sm text-gray-600">Publish your poems in text or video format</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="bx bx-message-dots text-2xl text-gray-600"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-900 mb-1">Engage in Chat Rooms</h3>
                                <p class="text-sm text-gray-600">Discuss literature with fellow enthusiasts</p>
                            </div>
                        </div>
                    </div>
                    <div class="bg-white border border-gray-200 rounded-lg p-6 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="bx bx-book text-2xl text-gray-600"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-semibold text-gray-900 mb-1">Explore Books</h3>
                                <p class="text-sm text-gray-600">Access our vast collection of eBooks</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <!-- For other auth pages (password reset, etc.) -->
        <div class="hidden lg:flex lg:flex-1 bg-gradient-to-br from-blue-900 via-purple-900 to-blue-800 relative overflow-hidden">
            <div class="absolute inset-0 bg-black opacity-20"></div>
            <div class="relative z-10 flex flex-col justify-center px-12 text-white">
                <h2 class="text-4xl font-semibold mb-4">Discover. Discuss. Connect.</h2>
                <p class="text-lg mb-8 opacity-90">
                    Access thousands of poems, join exclusive chatrooms, and support your favorite creators directly. Your next favorite verse is waiting.
                </p>
                <div class="flex gap-3">
                    <button class="px-4 py-2 border-2 border-white rounded-lg text-sm font-medium hover:bg-white hover:text-blue-900 transition-colors flex items-center gap-2">
                        <i class="bx bx-book"></i>
                        E-Library
                    </button>
                    <button class="px-4 py-2 border-2 border-white rounded-lg text-sm font-medium hover:bg-white hover:text-blue-900 transition-colors flex items-center gap-2">
                        <i class="bx bx-message-dots"></i>
                        Community
                    </button>
                    <button class="px-4 py-2 border-2 border-white rounded-lg text-sm font-medium hover:bg-white hover:text-blue-900 transition-colors flex items-center gap-2">
                        <i class="bx bx-check-circle"></i>
                        Creators
                    </button>
                </div>
            </div>
        </div>
        @endif
    </div>

    @yield('scripts')
</body>

</html>
