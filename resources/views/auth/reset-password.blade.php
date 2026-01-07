@extends('layouts.auth')

@section('title', 'Reset Password - VerseFountain')

@section('auth-content')
<div class="bg-white rounded-lg shadow-sm">
    <div class="p-8">
        <!-- Icon -->
        <div class="flex justify-center mb-6">
            <div class="w-16 h-16 bg-blue-600 rounded-full flex items-center justify-center">
                <i class="bx bx-refresh text-2xl text-white"></i>
            </div>
        </div>

        <!-- Header -->
        <div class="text-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-900 mb-2">Reset your password</h2>
            <p class="text-sm text-gray-600">Don't worry, it happens. Please enter the email address linked to your account.</p>
        </div>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <!-- Email Address -->
            <div class="space-y-2">
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <div class="relative">
                    <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus 
                           class="w-full pl-10 pr-3 py-2.5 border border-gray-300 rounded-lg focus:border-blue-600 focus:outline-none placeholder-gray-400"
                           placeholder="name@versefountain.com">
                    <i class="bx bx-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                @error('email')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                <div class="relative">
                    <input id="password" type="password" name="password" required 
                           class="w-full px-3 pr-10 py-2.5 border border-gray-300 rounded-lg focus:border-blue-600 focus:outline-none placeholder-gray-400"
                           placeholder="Enter new password">
                    <button type="button" onclick="togglePassword('password', this)" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i class="bx bx-hide"></i>
                    </button>
                </div>
                @error('password')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="space-y-2">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm New Password</label>
                <div class="relative">
                    <input id="password_confirmation" type="password" name="password_confirmation" required 
                           class="w-full px-3 pr-10 py-2.5 border border-gray-300 rounded-lg focus:border-blue-600 focus:outline-none placeholder-gray-400"
                           placeholder="Re-enter new password">
                    <button type="button" onclick="togglePassword('password_confirmation', this)" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i class="bx bx-hide"></i>
                    </button>
                </div>
                @error('password_confirmation')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full bg-blue-600 text-white py-2.5 px-4 font-medium hover:bg-blue-700 transition-colors rounded-lg">
                Reset Password
            </button>

            <!-- Back to Login -->
            <div class="text-center">
                <a href="{{ route('login') }}" 
                   class="text-sm text-gray-600 hover:text-gray-900 inline-flex items-center">
                    <i class="bx bx-arrow-back mr-1"></i>
                    Return to Log In
                </a>
            </div>
        </form>
    </div>
</div>

<script>
function togglePassword(fieldId, button) {
    const field = document.getElementById(fieldId);
    const icon = button.querySelector('i');
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('bx-hide');
        icon.classList.add('bx-show');
    } else {
        field.type = 'password';
        icon.classList.remove('bx-show');
        icon.classList.add('bx-hide');
    }
}
</script>
@endsection
