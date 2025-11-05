@props([
    'user' => [
        'name' => 'Admin User',
        'role' => 'Administrator',
        'initials' => 'AU'
    ],
    'title' => 'Admin Dashboard'
])

<header class="header">
    <div class="flex items-center justify-between px-6 py-4">
        <!-- Left Section -->
        <div class="flex items-center space-x-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $title }}</h1>
                <p class="text-sm text-gray-600">Welcome back, {{ $user->detail?->full_name }}</p>
            </div>
        </div>
        
        <!-- Right Section -->
        <div class="flex items-center space-x-4">
            
            <!-- User Menu -->
            <div class="flex items-center space-x-3">
                <div class="text-right hidden sm:block">
                    <p class="text-sm font-medium text-gray-800">{{ $user->detail?->full_name }}</p>
                    <p class="text-xs text-gray-500">{{ $user->roles->first()->name }}</p>
                </div>
                <div class="relative group">
                    <div class="w-10 h-10 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center cursor-pointer shadow-lg hover:shadow-xl transition-all duration-200">
                        <span class="text-white font-bold text-sm">{{ substr(strtoupper($user->detail?->full_name), 0,2) }}</span>
                    </div>
                    
                    <!-- Dropdown Menu -->
                    <div class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-lg border border-gray-200 opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-200 z-50">
                        <div class="py-2">
                            <!-- User Info -->
                            <div class="px-4 py-3 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-800">{{ $user->detail?->full_name }}</p>
                                <p class="text-xs text-gray-500">{{ $user->roles->first()->name }}</p>
                            </div>
                            
                            <!-- Logout -->
                            <div class="mt-2 pt-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                                        <i class="fas fa-sign-out-alt mr-3"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>