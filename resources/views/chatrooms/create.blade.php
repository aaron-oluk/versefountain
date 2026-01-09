@extends('layouts.app')

@section('title', 'Create Chatroom - VerseFountain')
@section('pageTitle', 'Create Chatroom')

@section('content')
<div class="max-w-xl mx-auto bg-white dark:bg-gray-800 rounded-xl border border-gray-200 dark:border-gray-700 p-6">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h1 class="text-xl font-bold text-gray-900 dark:text-white">Create a Chatroom</h1>
            <p class="text-sm text-gray-600 dark:text-gray-400">Start a new conversation space.</p>
        </div>
        <a href="{{ route('chatrooms.index') }}" class="inline-flex items-center text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">
            <i class="bx bx-arrow-back mr-1"></i> Back
        </a>
    </div>

    <form method="POST" action="{{ route('chatrooms.store') }}" class="space-y-4">
        @csrf
        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Room Name</label>
            <input name="name" type="text" required class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500" placeholder="e.g. Modern Poetry Circle">
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
            <textarea name="description" rows="3" class="w-full px-3 py-2 rounded-lg border border-gray-200 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:border-blue-500 focus:ring-1 focus:ring-blue-500" placeholder="What is this room about?"></textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
            <select name="category" class="w-full px-4 py-2.5 pr-10 rounded-lg border-2 border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 hover:border-gray-300 dark:hover:border-gray-600 transition-colors cursor-pointer font-medium appearance-none bg-[url('data:image/svg+xml;charset=utf-8,%3Csvg xmlns=%27http://www.w3.org/2000/svg%27 fill=%27none%27 viewBox=%270 0 20 20%27%3E%3Cpath stroke=%27%236B7280%27 stroke-linecap=%27round%27 stroke-linejoin=%27round%27 stroke-width=%271.5%27 d=%27m6 8 4 4 4-4%27/%3E%3C/svg%3E')] bg-[length:1.25rem] bg-[center_right_0.5rem] bg-no-repeat">
                <option value="general">General</option>
                <option value="poetry_slams">Poetry Slams</option>
                <option value="book_clubs">Book Clubs</option>
                <option value="author_qa">Author Q&A</option>
            </select>
        </div>

        <div class="flex items-center gap-2">
            <input id="is_private" name="is_private" type="checkbox" value="1" class="h-4 w-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
            <label for="is_private" class="text-sm text-gray-700 dark:text-gray-300">Make this room private</label>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm font-semibold rounded-lg hover:bg-blue-700 transition-colors">Create Room</button>
            <a href="{{ route('chatrooms.index') }}" class="text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-white">Cancel</a>
        </div>
    </form>
</div>
@endsection
