@extends('layouts.app')

@section('title', 'Settings - VerseFountain')
@section('pageTitle', 'Settings')

@section('content')
<div class="max-w-4xl mx-auto">
    <h1 class="text-2xl font-bold text-gray-900 mb-6">Settings</h1>

    <!-- Profile Settings -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Profile Information</h2>
            <p class="text-sm text-gray-500 mt-1">Update your account's profile information and email address.</p>
        </div>
        <form action="{{ route('settings.profile.update') }}" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PATCH')

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                    <input type="text" name="first_name" id="first_name"
                           value="{{ old('first_name', auth()->user()->first_name) }}"
                           class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    @error('first_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                    <input type="text" name="last_name" id="last_name"
                           value="{{ old('last_name', auth()->user()->last_name) }}"
                           class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    @error('last_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div>
                <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                <input type="text" name="username" id="username"
                       value="{{ old('username', auth()->user()->username) }}"
                       class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                @error('username')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                <input type="email" name="email" id="email"
                       value="{{ old('email', auth()->user()->email) }}"
                       class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    Save Changes
                </button>
            </div>

            @if(session('status') === 'profile-updated')
                <p class="text-green-600 text-sm">Profile updated successfully.</p>
            @endif
        </form>
    </div>

    <!-- Password Settings -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Update Password</h2>
            <p class="text-sm text-gray-500 mt-1">Ensure your account is using a long, random password to stay secure.</p>
        </div>
        <form action="{{ route('settings.password.update') }}" method="POST" class="p-6 space-y-4">
            @csrf
            @method('PATCH')

            <div>
                <label for="current_password" class="block text-sm font-medium text-gray-700 mb-1">Current Password</label>
                <input type="password" name="current_password" id="current_password"
                       class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                @error('current_password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                <input type="password" name="password" id="password"
                       class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
            </div>

            <div class="flex justify-end">
                <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-medium">
                    Update Password
                </button>
            </div>

            @if(session('status') === 'password-updated')
                <p class="text-green-600 text-sm">Password updated successfully.</p>
            @endif
        </form>
    </div>

    <!-- Subscription -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-900">Subscription</h2>
            <p class="text-sm text-gray-500 mt-1">Manage your subscription plan and billing.</p>
        </div>
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-medium text-gray-900">Current Plan: <span class="text-blue-600">Free</span></p>
                    <p class="text-sm text-gray-500 mt-1">Upgrade to access premium features</p>
                </div>
                <a href="{{ route('subscription') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors text-sm font-medium">
                    Manage Subscription
                </a>
            </div>
        </div>
    </div>

    <!-- Danger Zone -->
    <div class="bg-white rounded-xl shadow-sm border border-red-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-red-200 bg-red-50">
            <h2 class="text-lg font-semibold text-red-900">Danger Zone</h2>
            <p class="text-sm text-red-600 mt-1">Irreversible and destructive actions.</p>
        </div>
        <div class="p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="font-medium text-gray-900">Delete Account</p>
                    <p class="text-sm text-gray-500 mt-1">Permanently delete your account and all associated data.</p>
                </div>
                <button onclick="confirmDelete()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
                    Delete Account
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full mx-4 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-2">Delete Account</h3>
        <p class="text-gray-600 mb-4">Are you sure you want to delete your account? This action cannot be undone.</p>
        <form action="{{ route('profile.destroy') }}" method="POST">
            @csrf
            @method('DELETE')
            <div class="mb-4">
                <label for="delete_password" class="block text-sm font-medium text-gray-700 mb-1">Enter your password to confirm</label>
                <input type="password" name="password" id="delete_password" required
                       class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:border-red-500 focus:ring-1 focus:ring-red-500">
            </div>
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Cancel
                </button>
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                    Delete Account
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
function confirmDelete() {
    document.getElementById('deleteModal').classList.remove('hidden');
}

function closeDeleteModal() {
    document.getElementById('deleteModal').classList.add('hidden');
}
</script>
@endsection
