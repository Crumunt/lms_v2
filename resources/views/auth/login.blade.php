<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Main Container with Gradient Background -->
    <div class="flex justify-center items-center min-h-screen p-4">

        <!-- Login Form Container -->
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full overflow-hidden">

            <!-- Header Section with Gradient -->
            <div class="bg-gradient-to-r from-green-600 to-green-700 p-8 text-center">
                <h1 class="text-3xl font-bold text-white">Welcome Back</h1>
                <p class="text-green-100 mt-2">Log in to continue your learning journey</p>
            </div>

            <!-- Form Section -->
            <div class="p-8">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email Address -->
                    <div class="mb-5">
                        <x-input-label for="email" :value="__('Email Address')" class="text-gray-700 font-semibold" />
                        <x-text-input id="email"
                            class="block mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200"
                            type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                            placeholder="your@email.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div class="mb-5">
                        <x-input-label for="password" :value="__('Password')" class="text-gray-700 font-semibold" />
                        <x-text-input id="password"
                            class="block mt-2 w-full rounded-lg border-gray-300 shadow-sm focus:ring-2 focus:ring-green-500 focus:border-green-500 transition duration-200"
                            type="password" name="password" required autocomplete="current-password"
                            placeholder="Enter your password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me & Forgot Password -->
                    <div class="flex items-center justify-between mb-6">
                        <label for="remember_me" class="inline-flex items-center cursor-pointer">
                            <input id="remember_me" type="checkbox"
                                class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500 cursor-pointer"
                                name="remember">
                            <span class="ml-2 text-sm text-gray-600 hover:text-gray-800">{{ __('Remember me') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-green-600 hover:text-green-700 font-medium transition"
                                href="{{ route('password.request') }}">
                                {{ __('Forgot password?') }}
                            </a>
                        @endif
                    </div>

                    <!-- Login Button -->
                    <x-primary-button
                        class="w-full justify-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:ring-4 focus:ring-green-300 transition duration-200 font-semibold">
                        {{ __('Log In') }}
                    </x-primary-button>

                    <!-- Social Login Divider -->
                    @if (Route::has('social.redirect'))
                        <div class="relative my-6">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-4 bg-white text-gray-500">Or continue with</span>
                            </div>
                        </div>

                        <!-- Social Login Buttons -->
                        <div class="space-y-3">
                            <!-- Google Login Button -->
                            <a href="{{ route('social.redirect', 'google') }}"
                                class="flex items-center justify-center w-full bg-white border-2 border-gray-300 rounded-lg py-3 px-4 hover:bg-gray-50 hover:border-gray-400 transition duration-200">
                                <svg class="w-5 h-5 mr-3" viewBox="0 0 24 24">
                                    <path fill="#4285F4"
                                        d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" />
                                    <path fill="#34A853"
                                        d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" />
                                    <path fill="#FBBC05"
                                        d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" />
                                    <path fill="#EA4335"
                                        d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" />
                                </svg>
                                <span class="font-medium text-gray-700">Continue with Google</span>
                            </a>

                            <!-- Facebook Login Button -->
                            <a href="{{ route('social.redirect', 'facebook') }}"
                                class="flex items-center justify-center w-full bg-blue-600 text-white rounded-lg py-3 px-4 hover:bg-blue-700 transition duration-200">
                                <svg class="w-5 h-5 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                </svg>
                                <span class="font-medium">Continue with Facebook</span>
                            </a>
                        </div>
                    @endif

                    <!-- Sign Up Link -->
                    <div class="text-center mt-6">
                        <p class="text-gray-600">
                            Don't have an account?
                            <a href="{{ route('register') }}"
                                class="text-green-600 hover:text-green-700 font-semibold transition">
                                {{ __('Sign Up') }}
                            </a>
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>