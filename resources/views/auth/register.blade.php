@extends('layouts.auth')

@section('title', 'Register - VerseFountain')

@section('auth-content')
<div>
    <!-- Header -->
    <div class="mb-8 text-center">
        <h2 class="text-4xl font-bold text-gray-900 dark:text-white mb-2">Join VerseFountain</h2>
        <p class="text-gray-600 dark:text-gray-400">Start your reading journey and connect with fellow readers</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <!-- Username -->
        <div class="space-y-2">
            <label for="username" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Username</label>
            <div class="relative">
                <i class="bx bx-user absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500"></i>
                <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus autocomplete="username" 
                       class="w-full pl-11 pr-4 py-2.5 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400 transition-colors"
                       placeholder="Choose your username">
            </div>
            @error('username')
                <p class="text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="space-y-2">
            <label for="email" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Email Address</label>
            <div class="relative">
                <i class="bx bx-envelope absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500"></i>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" 
                       class="w-full pl-11 pr-4 py-2.5 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400 transition-colors"
                       placeholder="name@example.com">
            </div>
            @error('email')
                <p class="text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="space-y-2">
            <label for="password" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Password</label>
            <div class="relative">
                <i class="bx bx-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500"></i>
                <input id="password" type="password" name="password" required autocomplete="new-password"
                       class="w-full pl-11 pr-11 py-2.5 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400 transition-colors"
                       placeholder="Create a strong password">
                <button type="button" onclick="togglePasswordVisibility('password', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-400">
                    <i class="bx bx-hide"></i>
                </button>
            </div>
            @error('password')
                <p class="text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="space-y-2">
            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Confirm Password</label>
            <div class="relative">
                <i class="bx bx-lock absolute left-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500"></i>
                <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                       class="w-full pl-11 pr-11 py-2.5 border border-gray-300 dark:border-gray-700 bg-white dark:bg-gray-800 text-gray-900 dark:text-white placeholder-gray-400 dark:placeholder-gray-500 rounded-lg focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 dark:focus:border-blue-400 dark:focus:ring-blue-400 transition-colors"
                       placeholder="Confirm your password">
                <button type="button" onclick="togglePasswordVisibility('password_confirmation', this)" class="absolute right-4 top-1/2 -translate-y-1/2 text-gray-400 dark:text-gray-500 hover:text-gray-600 dark:hover:text-gray-400">
                    <i class="bx bx-hide"></i>
                </button>
            </div>
            @error('password_confirmation')
                <p class="text-sm text-red-500 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

        <!-- Terms Checkbox -->
        <div class="flex items-start gap-2 pt-2">
            <input id="terms" type="checkbox" name="terms" required
                   class="w-4 h-4 text-blue-600 border-gray-300 dark:border-gray-700 rounded focus:ring-0 mt-1">
            <label for="terms" class="text-sm text-gray-700 dark:text-gray-300">
                I agree to the <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">Terms of Service</a> and <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">Privacy Policy</a>
            </label>
        </div>

        <!-- Submit Button -->
        <button type="submit" 
                class="w-full mt-6 bg-blue-600 hover:bg-blue-700 text-white py-2.5 px-4 font-semibold rounded-lg transition-colors">
            Create Account
        </button>
    </form>

    <!-- Divider -->
    <div class="relative my-6">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-300 dark:border-gray-700"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="px-2 bg-white dark:bg-gray-900 text-gray-500 dark:text-gray-400">Already have an account?</span>
        </div>
    </div>

    <!-- Login Link -->
    <a href="{{ route('login') }}" 
       class="block w-full text-center px-4 py-2.5 border border-gray-300 dark:border-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
        Sign In
    </a>

    <!-- Legal Text -->
    <p class="mt-6 text-xs text-gray-500 dark:text-gray-400 text-center">
        By creating an account, you agree to our <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">Terms</a> and <a href="#" class="text-blue-600 dark:text-blue-400 hover:underline">Privacy Policy</a>
    </p>
</div>

<script>
function togglePasswordVisibility(fieldId, button) {
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
