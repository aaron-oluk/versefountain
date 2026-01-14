@extends('layouts.app')

@section('title', ($book->title ?? 'Book') . ' - VerseFountain')

@section('content')
<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
        <!-- Back Button -->
        <div class="mb-6">
            <a href="{{ url()->previous() ?? route('books.index') }}" 
               class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm font-medium transition-colors">
                <i class="bx bx-arrow-back text-base mr-1"></i>
                Back
            </a>
        </div>

        <div class="max-w-4xl mx-auto">
            <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg border border-gray-200 dark:border-gray-700">
                <!-- Header -->
                <div class="p-6 sm:p-8 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h1 class="text-2xl md:text-3xl font-semibold text-gray-900 dark:text-white mb-3">{{ $book->title ?? 'Untitled' }}</h1>
                            <div class="flex flex-wrap items-center gap-4 text-gray-600 dark:text-gray-400">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-medium">By {{ $book->author ?? 'Unknown' }}</span>
                                </div>
                                <span class="text-gray-400 dark:text-gray-600">•</span>
                                <span class="text-sm">{{ $book->genre ?? 'General' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Content -->
                <div class="p-6 sm:p-8">
                    <div class="prose prose-lg max-w-none dark:prose-invert">
                        <div class="whitespace-pre-line text-gray-700 dark:text-gray-300 leading-relaxed">
                            {{ $book->description ?? 'No description available.' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
