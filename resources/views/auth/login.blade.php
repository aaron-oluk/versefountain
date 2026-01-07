@extends('layouts.auth')

@section('title', 'Login - VerseFountain')

@section('auth-content')
<div class="bg-white rounded-lg shadow-sm">
    <div class="p-8">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-semibold text-gray-900 mb-2">Welcome to VerseFountain</h2>
            <p class="text-sm text-gray-600">Sign in to your account to continue</p>
        </div>

        <!-- Tab Toggle -->
        <div class="flex gap-2 mb-6">
            <a href="{{ route('register') }}" 
               class="flex-1 px-4 py-2 text-center text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                Register
            </a>
            <a href="{{ route('login') }}" 
               class="flex-1 px-4 py-2 text-center text-sm font-medium text-white bg-blue-600 rounded-lg">
                Login
            </a>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div class="mb-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <p class="text-sm text-blue-800">{{ session('status') }}</p>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <!-- Email Address -->
            <div class="space-y-2">
                <label for="email" class="block text-xs font-medium text-gray-700 uppercase tracking-wide">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                       class="w-full px-3 py-2.5 border border-gray-300 focus:border-blue-600 bg-white focus:outline-none placeholder-gray-400 text-sm rounded-lg transition-colors"
                       placeholder="Enter your email">
                @error('email')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <label for="password" class="block text-xs font-medium text-gray-700 uppercase tracking-wide">Password</label>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                       class="w-full px-3 py-2.5 border border-gray-300 focus:border-blue-600 bg-white focus:outline-none placeholder-gray-400 text-sm rounded-lg transition-colors"
                       placeholder="Enter your password">
                @error('password')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="flex items-center">
                <input id="remember_me" type="checkbox" name="remember" 
                       class="h-4 w-4 text-blue-600 focus:ring-0 focus:ring-offset-0 border-gray-300 rounded">
                <label for="remember_me" class="ml-2 block text-sm text-gray-700">
                    Remember me
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full bg-blue-600 text-white py-2.5 px-4 font-medium hover:bg-blue-700 transition-colors text-sm rounded-lg">
                Sign In
            </button>

            <!-- Forgot Password -->
            @if (Route::has('password.request'))
                <div class="text-center">
                    <a href="{{ route('password.request') }}" 
                       class="text-sm text-gray-600 hover:text-gray-900">
                        Forgot your password?
                    </a>
                </div>
            @endif
        </form>

        <!-- Legal Text -->
        <p class="mt-6 text-xs text-gray-500 text-center">
            By signing in, you agree to our Terms of Service and Privacy Policy.
        </p>
    </div>
</div>
@endsection
