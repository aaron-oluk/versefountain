@extends('layouts.app')

@section('title', 'Academic Resources - VerseFountain')
@section('pageTitle', 'Academic Resources')

@section('content')
    <div class="min-h-screen bg-white dark:bg-gray-900 flex flex-col">
        <!-- Clean Header -->
        <div class="border-b border-gray-200 dark:border-gray-800 py-6 sm:py-8">
            <div class="px-4 sm:px-6 lg:px-8">
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-bold text-gray-900 dark:text-white mb-2">Academic Resources
                </h1>
                <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Discover research papers, learning guides,
                    and educational materials</p>
            </div>
        </div>

        <div class="px-4 sm:px-6 lg:px-8 py-6 sm:py-8 flex-1">
            <!-- Search Bar -->
            <div class="mb-8 sm:mb-12 max-w-2xl">
                <div class="relative">
                    <i class="bx bx-search absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500"></i>
                    <input type="text" id="searchResources" placeholder="Search papers, topics, subjects..."
                        class="w-full pl-11 pr-4 py-2.5 border border-gray-300 dark:border-gray-700 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 text-sm">
                </div>
            </div>

            <!-- Featured Resources -->
            @if ($featuredResources->count() > 0)
                <div class="mb-12 sm:mb-16">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-4 sm:mb-6">Featured</h2>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4 sm:gap-6">
                        @foreach ($featuredResources as $resource)
                            <a href="#" class="group">
                                <div
                                    class="relative rounded-xl overflow-hidden mb-4 bg-gradient-to-br from-blue-100 dark:from-blue-900/40 to-cyan-100 dark:to-cyan-900/40 aspect-video flex items-center justify-center">
                                    <i class="bx bx-book text-6xl text-blue-600 dark:text-blue-400 opacity-60"></i>
                                </div>
                                <h3
                                    class="font-semibold text-gray-900 dark:text-white mb-2 line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors text-sm">
                                    {{ $resource->title }}</h3>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mb-2">
                                    {{ $resource->subject ?? 'Academic' }}</p>
                                <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-500">
                                    <span>{{ $resource->created_at->format('M d, Y') }}</span>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Browse by Subject -->
            @if ($subjects->count() > 0)
                <div class="mb-12 sm:mb-16">
                    <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-4 sm:mb-6">Browse by Subject
                    </h2>
                    <div
                        class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 gap-3 sm:gap-4">
                        @foreach ($subjects as $subject)
                            <a href="#"
                                class="group p-4 rounded-lg border border-gray-200 dark:border-gray-800 hover:border-blue-500 dark:hover:border-blue-400 bg-white dark:bg-gray-800 transition-all">
                                <div class="text-center">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-blue-50 dark:bg-blue-900/20 flex items-center justify-center mx-auto mb-2 group-hover:bg-blue-100 dark:group-hover:bg-blue-800/40 transition-colors">
                                        <i class="bx bx-book-bookmark text-lg text-blue-600 dark:text-blue-400"></i>
                                    </div>
                                    <p
                                        class="text-xs font-medium text-gray-900 dark:text-white group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors line-clamp-2">
                                        {{ $subject }}</p>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Recent Papers -->
            <div>
                <h2 class="text-xl sm:text-2xl font-bold text-gray-900 dark:text-white mb-4 sm:mb-6">Recent Papers</h2>
                @if ($recentPapers->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-3 sm:gap-4 mb-6 sm:mb-8">
                        @foreach ($recentPapers as $paper)
                            <a href="#"
                                class="group p-4 rounded-lg border border-gray-200 dark:border-gray-800 bg-white dark:bg-gray-800 hover:border-blue-500 dark:hover:border-blue-400 hover:shadow-md dark:hover:shadow-lg transition-all">
                                <div class="flex items-start gap-3 mb-3">
                                    <div
                                        class="w-10 h-10 rounded-lg bg-purple-50 dark:bg-purple-900/20 flex items-center justify-center flex-shrink-0 group-hover:bg-purple-100 dark:group-hover:bg-purple-800/40 transition-colors">
                                        <i class="bx bx-file-pdf text-lg text-purple-600 dark:text-purple-400"></i>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3
                                            class="font-semibold text-gray-900 dark:text-white line-clamp-2 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors text-sm">
                                            {{ $paper->title }}</h3>
                                    </div>
                                </div>
                                <p class="text-xs text-gray-600 dark:text-gray-400 mb-3">{{ $paper->subject ?? 'General' }}
                                </p>
                                <p class="text-xs text-gray-700 dark:text-gray-300 mb-3 line-clamp-2">
                                    {{ $paper->description ?? 'No description available' }}</p>
                                <div
                                    class="flex items-center justify-between pt-3 border-t border-gray-200 dark:border-gray-700">
                                    <span
                                        class="text-xs text-gray-500 dark:text-gray-500">{{ $paper->created_at->format('M d, Y') }}</span>
                                    <span class="text-xs font-semibold text-blue-600 dark:text-blue-400">Download</span>
                                </div>
                            </a>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="flex justify-center my-8">
                        {{ $recentPapers->links() }}
                    </div>
                @else
                    <div
                        class="text-center py-16 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-800">
                        <i class="bx bx-file text-6xl text-gray-300 dark:text-gray-600 mb-4 block"></i>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">No papers found</h3>
                        <p class="text-gray-600 dark:text-gray-400">Try adjusting your search</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
