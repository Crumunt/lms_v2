<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Main Container with Light Background -->
    <div
        class="flex justify-center items-center min-h-screen bg-gradient-to-r from-green-500 via-green-600 to-green-700">

        <!-- Login Form Container with Transparent White Background -->
        <div class="bg-white bg-opacity-90 p-8 rounded-lg shadow-lg max-w-md w-full">

            <!-- Header Section -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-800">Welcome to ByteLearn</h1>
                <p class="text-sm text-gray-600 mt-2">Your gateway to learning and knowledge</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email Address')" />
                    <x-text-input id="email"
                        class="block mt-1 w-full rounded-lg border-gray-300 shadow-md focus:ring-green-500 focus:border-green-500"
                        type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password"
                        class="block mt-1 w-full rounded-lg border-gray-300 shadow-md focus:ring-green-500 focus:border-green-500"
                        type="password" name="password" required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox"
                            class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500"
                            name="remember">
                        <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                    </label>
                </div>

                <!-- Forgot Password Link -->
                <div class="flex items-center justify-between mt-4">
                    @if (Route::has('password.request'))
                        <a class="underline text-sm text-gray-600 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                            href="{{ route('password.request') }}">
                            {{ __('Forgot your password?') }}
                        </a>
                    @endif

                    <x-primary-button
                        class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        {{ __('Log in') }}
                    </x-primary-button>
                </div>

                <!-- Social Login Options -->
                @if (Route::has('google.login') || Route::has('facebook.login'))
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">Or log in with</p>

                        <div class="mt-4 flex justify-center space-x-4">
                            <!-- Google Login Button -->
                            @if (Route::has('google.login'))
                                <a href=""
                                    class="inline-flex items-center justify-center px-6 py-2 bg-red-500 text-white rounded-lg shadow-md hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="currentColor"
                                        viewBox="0 0 48 48" aria-hidden="true">
                                        <path
                                            d="M23.49 12.3c0-.72-.06-1.41-.17-2.07H12v4.06h6.34c-.27 1.52-1.06 2.81-2.22 3.57v3h3.56c2.09-1.94 3.28-4.81 3.28-8.06z">
                                        </path>
                                        <path
                                            d="M12 6.23c1.1 0 2.04.37 2.77.99L17.35 5C15.87 3.68 13.65 2.88 11.12 2.88c-3.37 0-6.21 2.28-7.24 5.37h3.77C8.4 6.74 9.57 6.23 12 6.23z">
                                        </path>
                                        <path
                                            d="M4.88 3.25C3.25 5.56 2.88 7.95 2.88 11.12c0 3.37 1.68 6.34 4.13 8.06l3.77-3c-.77-.56-1.34-1.33-1.34-2.21C9.54 11.3 10.66 9.4 12 8.5c-1.1 0-2.04-.37-2.77-.99L4.88 3.25z">
                                        </path>
                                    </svg>
                                    Google
                                </a>
                            @endif

                            <!-- Facebook Login Button -->
                            @if (Route::has('facebook.login'))
                                <a href=""
                                    class="inline-flex items-center justify-center px-6 py-2 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2" fill="currentColor"
                                        viewBox="0 0 48 48" aria-hidden="true">
                                        <path
                                            d="M25.9 0C23.35 0 20.99 1.31 19.51 3.46c-1.27 1.53-1.99 3.4-1.99 5.36v5.48h-4.6V14h4.6V9.29c0-5.04 3.01-8.29 7.62-8.29 2.2 0 4.2 0.16 4.74 0.24v5.43h-3.22c-2.52 0-3.19 1.9-3.19 3.87v4.63h6.4l-1.02 6.12h-5.38v15h-7.14V18.1h-4.6v-6.12h4.6V3.46C20.99 1.31 23.35 0 25.9 0z">
                                        </path>
                                    </svg>
                                    Facebook
                                </a>
                            @endif
                        </div>
                    </div>
                @endif
            </form>
        </div>
    </div>
</x-guest-layout>