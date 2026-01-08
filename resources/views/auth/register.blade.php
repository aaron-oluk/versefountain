@extends('layouts.auth')

@section('title', 'Register - VerseFountain')

@section('auth-content')
<div class="bg-white rounded-lg shadow-sm">
    <div class="p-8">
        <!-- Header -->
        <div class="mb-8">
            <h2 class="text-3xl font-semibold text-gray-900 mb-2">Create your account</h2>
            <p class="text-sm text-gray-600">Join the conversation and start your reading journey today.</p>
        </div>

        <!-- Tab Toggle -->
        <div class="flex gap-2 mb-6">
            <a href="{{ route('register') }}" 
               class="flex-1 px-4 py-2 text-center text-sm font-medium text-white bg-blue-600 rounded-lg">
                Register
            </a>
            <a href="{{ route('login') }}" 
               class="flex-1 px-4 py-2 text-center text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                Login
            </a>
        </div>

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <!-- Username -->
            <div class="space-y-2">
                <label for="username" class="block text-xs font-medium text-gray-700 uppercase tracking-wide">Username</label>
                <div class="relative">
                    <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus autocomplete="username" 
                           class="w-full pl-10 pr-3 py-2.5 border border-gray-300 focus:border-blue-600 bg-white focus:outline-none placeholder-gray-400 text-sm rounded-lg transition-colors"
                           placeholder="e.g., Emily Dickinson">
                    <i class="bx bx-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                @error('username')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="space-y-2">
                <label for="email" class="block text-xs font-medium text-gray-700 uppercase tracking-wide">Email address</label>
                <div class="relative">
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" 
                           class="w-full pl-10 pr-3 py-2.5 border border-gray-300 focus:border-blue-600 bg-white focus:outline-none placeholder-gray-400 text-sm rounded-lg transition-colors"
                           placeholder="name@example.com">
                    <i class="bx bx-envelope absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                @error('email')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <label for="password" class="block text-xs font-medium text-gray-700 uppercase tracking-wide">Password</label>
                <div class="relative">
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           class="w-full pl-10 pr-10 py-2.5 border border-gray-300 focus:border-blue-600 bg-white focus:outline-none placeholder-gray-400 text-sm rounded-lg transition-colors"
                           placeholder="Create a password">
                    <i class="bx bx-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
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
                <label for="password_confirmation" class="block text-xs font-medium text-gray-700 uppercase tracking-wide">Confirm Password</label>
                <div class="relative">
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           class="w-full pl-10 pr-10 py-2.5 border border-gray-300 focus:border-blue-600 bg-white focus:outline-none placeholder-gray-400 text-sm rounded-lg transition-colors"
                           placeholder="Confirm your password">
                    <i class="bx bx-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <button type="button" onclick="togglePassword('password_confirmation', this)" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i class="bx bx-hide"></i>
                    </button>
                </div>
                @error('password_confirmation')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Terms Checkbox -->
            <div class="flex items-start">
                <input id="terms" type="checkbox" name="terms" required
                       class="h-4 w-4 text-blue-600 focus:ring-0 focus:ring-offset-0 border-gray-300 rounded mt-0.5">
                <label for="terms" class="ml-2 block text-sm text-gray-700">
                    I agree to the <a href="#" class="text-blue-600 hover:underline">Terms of Service</a> and <a href="#" class="text-blue-600 hover:underline">Privacy Policy</a>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" 
                    class="w-full bg-blue-600 text-white py-2.5 px-4 font-medium hover:bg-blue-700 transition-colors text-sm rounded-lg">
                Register
            </button>

            <!-- Divider -->
            <div class="relative my-6">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">Or sign up with</span>
                </div>
            </div>

            <!-- Social Login Buttons -->
            <div class="grid grid-cols-2 gap-3">
                <button type="button" class="flex items-center justify-center px-4 py-2.5 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-700">Google</span>
                </button>
                <button type="button" class="flex items-center justify-center px-4 py-2.5 border border-gray-300 rounded-lg hover:bg-gray-50 transition-colors">
                    <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M17.05 20.28c-.98.95-2.05.88-3.08.4-1.09-.5-2.08-.96-3.24-1.44-1.56-.65-2.53-1.1-2.53-1.9 0-.72.57-1.33 1.73-1.88.58-.28 1.23-.54 1.92-.78L4.5 9.5c-1.1.53-2.1 1.04-3.1 1.64C.73 11.1 0 12 0 13c0 1.12.9 2.1 2.1 2.1.33 0 .65-.05.96-.14C5.69 14.5 7.77 14 9.73 13.65c-.31.42-.6.86-.87 1.32-.4.68-.76 1.4-1.08 2.14-.08.18-.15.36-.22.54-.15.4-.28.8-.4 1.2-.1.35-.2.7-.28 1.05-.08.37-.15.74-.2 1.12-.03.25-.05.5-.07.75 0 .2-.02.4-.02.6 0 .4.02.8.05 1.2.04.6.1 1.2.2 1.8.13.7.3 1.4.5 2.1.21.7.5 1.4.85 2.08.46.9 1.05 1.75 1.8 2.5.7.7 1.55 1.25 2.45 1.65.9.4 1.85.65 2.8.75.95.1 1.9.05 2.85-.15.95-.2 1.85-.55 2.7-1.05.85-.5 1.65-1.15 2.35-1.95.7-.8 1.3-1.7 1.75-2.65.45-.95.75-1.95.9-3 .15-1.05.15-2.1 0-3.15-.15-1.05-.45-2.05-.9-3-.45-.95-1.05-1.85-1.75-2.65-.7-.8-1.5-1.45-2.35-1.95-.85-.5-1.75-.85-2.7-1.05-.95-.2-1.9-.25-2.85-.15-.95.1-1.9.35-2.8.75-.9.4-1.75.95-2.45 1.65-.75.75-1.34 1.6-1.8 2.5-.35.68-.64 1.38-.85 2.08-.2.7-.37 1.4-.5 2.1-.1.6-.16 1.2-.2 1.8-.03.4-.05.8-.05 1.2 0 .2.02.4.02.6.02.25.04.5.07.75.05.38.12.75.2 1.12.08.35.18.7.28 1.05.12.4.25.8.4 1.2.07.18.14.36.22.54.32.74.68 1.46 1.08 2.14.27.46.56.9.87 1.32z"/>
                    </svg>
                    <span class="text-sm font-medium text-gray-700">Apple</span>
                </button>
            </div>

            <!-- Login Link -->
            <div class="text-center mt-6">
                <p class="text-sm text-gray-600">
                    Already have an account? <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-medium">Log in</a>
                </p>
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
