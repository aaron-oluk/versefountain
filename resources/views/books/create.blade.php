@extends('layouts.app')

@section('title', 'Add New Book - VerseFountain')

@section('content')
<div class="container mx-auto px-4 sm:px-6 lg:px-8 py-6 sm:py-8">
    <div class="max-w-4xl mx-auto">
        <div class="mb-6 sm:mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white mb-2">Add New Book</h1>
                    <p class="text-sm sm:text-base text-gray-600 dark:text-gray-400">Share a book with the community</p>
                </div>
                <a href="{{ route('books.index') }}" 
                   class="inline-flex items-center text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white text-sm">
                    <i class="bx bx-arrow-back text-base mr-1"></i>
                    Back
                </a>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 rounded-md shadow-sm p-4 sm:p-6">
            <form id="book-create-form" data-book-form>
                <div class="space-y-6">
                    <!-- Cover Image Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Cover Image
                        </label>
                        <div class="flex items-center space-x-4">
                            <div id="cover-preview" class="w-32 h-48 bg-gray-100 dark:bg-gray-700 rounded-md flex items-center justify-center overflow-hidden">
                                <i class="bx bx-image text-4xl text-gray-400 dark:text-gray-500"></i>
                            </div>
                            <div class="flex-1">
                                <input type="file" id="cover-input" accept="image/*" class="hidden">
                                <button type="button" id="upload-cover-btn"
                                    class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 rounded-md hover:bg-gray-200 dark:hover:bg-gray-600 transition-colors">
                                    Choose File
                                </button>
                                <input type="hidden" name="coverImage" id="cover-url">
                                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">PNG, JPG, GIF up to 10MB</p>
                            </div>
                        </div>
                    </div>

                    <!-- Title -->
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Title <span class="text-red-500">*</span>
                        </label>
                        <input id="title" 
                               name="title" 
                               type="text" 
                               required
                               placeholder="Enter book title"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                    </div>

                    <!-- Author -->
                    <div>
                        <label for="author" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Author <span class="text-red-500">*</span>
                        </label>
                        <input id="author" 
                               name="author" 
                               type="text" 
                               required
                               placeholder="Enter author name"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                    </div>

                    <!-- Genre -->
                    <div>
                        <label for="genre" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Genre
                        </label>
                        <input id="genre" 
                               name="genre" 
                               type="text" 
                               placeholder="e.g., Fiction, Non-Fiction, Poetry"
                               class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500">
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                            Description
                        </label>
                        <textarea id="description" 
                                  name="description" 
                                  rows="6"
                                  placeholder="Enter book description, summary, or notes..."
                                  class="w-full px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white dark:bg-gray-700 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500"></textarea>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-between items-center pt-4">
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            <i class="bx bx-info-circle"></i> Books require admin approval before being published
                        </p>
                        <div class="flex space-x-3">
                            <a href="{{ route('books.index') }}"
                                class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                Cancel
                            </a>
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white text-sm font-medium rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition-colors">
                                Add Book
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('book-create-form');
    const coverInput = document.getElementById('cover-input');
    const uploadBtn = document.getElementById('upload-cover-btn');
    const coverPreview = document.getElementById('cover-preview');
    const coverUrlInput = document.getElementById('cover-url');
    
    const bookManager = new BookManager();

    // Cover upload handling
    uploadBtn.addEventListener('click', () => coverInput.click());
    
    coverInput.addEventListener('change', async function(e) {
        const file = e.target.files[0];
        if (!file) return;

        // Preview
        const reader = new FileReader();
        reader.onload = (e) => {
            coverPreview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover" alt="Cover preview">`;
        };
        reader.readAsDataURL(file);

        // Upload (create placeholder book first if needed, or upload to temp storage)
        // For now, we'll store the data URL and upload after book creation
        coverUrlInput.value = await new Promise(resolve => {
            const reader = new FileReader();
            reader.onload = (e) => resolve(e.target.result);
            reader.readAsDataURL(file);
        });
    });

    // Form handler
    const formHandler = new CRUDFormHandler(form, {
        async onSubmit(formData) {
            // Create book
            const book = await bookManager.create(formData);
            return book;
        },
        onSuccess(book) {
            if (book) {
                setTimeout(() => {
                    window.location.href = '/books';
                }, 1500);
            }
        },
        onError(error) {
            console.error('Book creation error:', error);
        }
    });
});
</script>
@endsection
