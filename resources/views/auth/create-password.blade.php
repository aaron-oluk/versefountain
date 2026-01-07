@extends('layouts.auth')

@section('title', 'Create New Password - VerseFountain')

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
            <h2 class="text-2xl font-semibold text-gray-900 mb-2">Create New Password</h2>
            <p class="text-sm text-gray-600">Please choose a unique password to regain access to your library.</p>
        </div>

        <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') ?? '' }}">

            <!-- New Password -->
            <div class="space-y-2">
                <label for="password" class="block text-sm font-medium text-gray-700">New Password</label>
                <div class="relative">
                    <input id="password" type="password" name="password" required 
                           class="w-full px-3 pr-10 py-2.5 border border-gray-300 rounded-lg focus:border-blue-600 focus:outline-none placeholder-gray-400"
                           placeholder="Enter new password"
                           oninput="checkPasswordStrength(this.value)">
                    <button type="button" onclick="togglePassword('password', this)" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600">
                        <i class="bx bx-hide"></i>
                    </button>
                </div>
                
                <!-- Password Strength Indicator -->
                <div class="mt-2">
                    <div class="h-1.5 bg-gray-200 rounded-full overflow-hidden">
                        <div id="strength-bar" class="h-full transition-all duration-300" style="width: 0%"></div>
                    </div>
                    <p id="strength-text" class="text-xs mt-1 text-gray-500">Strength: <span id="strength-level">-</span></p>
                </div>
                
                @error('password')
                    <p class="text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Password Requirements -->
            <div class="space-y-2">
                <p class="text-xs font-medium text-gray-700 uppercase">Password Requirements:</p>
                <div class="space-y-1.5">
                    <div class="flex items-center">
                        <input type="checkbox" id="req-length" disabled class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <label for="req-length" class="ml-2 text-sm text-gray-600">At least 8 characters long</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="req-number" disabled class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <label for="req-number" class="ml-2 text-sm text-gray-600">Contains at least one number</label>
                    </div>
                    <div class="flex items-center">
                        <input type="checkbox" id="req-special" disabled class="h-4 w-4 text-blue-600 border-gray-300 rounded">
                        <label for="req-special" class="ml-2 text-sm text-gray-600">Contains at least one special symbol</label>
                    </div>
                </div>
            </div>

            <!-- Confirm New Password -->
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

function checkPasswordStrength(password) {
    const strengthBar = document.getElementById('strength-bar');
    const strengthLevel = document.getElementById('strength-level');
    const reqLength = document.getElementById('req-length');
    const reqNumber = document.getElementById('req-number');
    const reqSpecial = document.getElementById('req-special');
    
    let strength = 0;
    let level = 'Weak';
    let color = 'bg-red-500';
    
    // Check length
    if (password.length >= 8) {
        strength += 33;
        reqLength.checked = true;
    } else {
        reqLength.checked = false;
    }
    
    // Check for number
    if (/\d/.test(password)) {
        strength += 33;
        reqNumber.checked = true;
    } else {
        reqNumber.checked = false;
    }
    
    // Check for special character
    if (/[!@#$%^&*(),.?":{}|<>]/.test(password)) {
        strength += 34;
        reqSpecial.checked = true;
    } else {
        reqSpecial.checked = false;
    }
    
    // Determine level
    if (strength >= 100) {
        level = 'Strong';
        color = 'bg-green-500';
    } else if (strength >= 66) {
        level = 'Medium';
        color = 'bg-blue-500';
    } else if (strength >= 33) {
        level = 'Weak';
        color = 'bg-yellow-500';
    } else {
        level = '-';
        color = 'bg-gray-300';
    }
    
    strengthBar.style.width = strength + '%';
    strengthBar.className = 'h-full transition-all duration-300 ' + color;
    strengthLevel.textContent = level;
    if (level !== '-') {
        strengthLevel.className = level === 'Strong' ? 'text-green-600' : level === 'Medium' ? 'text-blue-600' : 'text-yellow-600';
    }
}
</script>
@endsection

