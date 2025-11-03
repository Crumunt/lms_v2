@props([
    'user' => [
        'name' => 'Dr. Lorenz',
        'department' => 'Computer Science',
        'initials' => 'JS'
    ]
])

<header class="header glass-effect">
    <div class="flex items-center justify-between px-6 py-4">
        <div class="flex items-center">
            <button id="menu-toggle" class="mr-4 text-gray-700 hover:text-gray-900 lg:hidden transition" onclick="toggleSidebar()">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <div>
                <h1 class="text-2xl font-bold bg-gradient-to-r from-purple-700 to-pink-500 bg-clip-text text-transparent">
                    Instructor Dashboard
                </h1>
                <p class="text-sm text-gray-500 mt-1">Welcome back, {{ $user->detail?->full_name }}!</p>
            </div>
        </div>
        
        <div class="flex items-center space-x-4">
            <div class="relative hidden md:block">
                <input type="text" placeholder="Search courses, students, assignments..." 
                       class="search-input py-2.5 pl-12 pr-4 w-80 border border-gray-200 rounded-xl focus:outline-none text-sm">
                <i class="fas fa-search absolute left-4 top-3 text-gray-400"></i>
            </div>
            
            <!-- <button class="relative p-2.5 rounded-xl hover:bg-gray-100 transition">
                <i class="fas fa-bell text-gray-600 text-lg"></i>
                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
            
            <button class="p-2.5 rounded-xl hover:bg-gray-100 transition">
                <i class="fas fa-envelope text-gray-600 text-lg"></i>
            </button> -->
            
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" @click.away="open = false" class="flex items-center space-x-3 pl-4 border-l border-gray-200 hover:bg-gray-50 rounded-lg transition py-2 px-2">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-400 to-pink-400 flex items-center justify-center text-white text-sm font-bold">
                        {{ strtoupper(substr($user->detail?->full_name ?? $user->name, 0, 2)) }}
                    </div>
                    <div class="hidden md:block">
                        <p class="text-sm font-medium text-gray-800">{{ $user->detail?->full_name }}</p>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 text-xs transition-transform" :class="{ 'rotate-180': open }"></i>
                </button>

                <!-- Dropdown Menu -->
                <div x-show="open"
                    x-transition:enter="transition ease-out duration-100"
                    x-transition:enter-start="transform opacity-0 scale-95"
                    x-transition:enter-end="transform opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-75"
                    x-transition:leave-start="transform opacity-100 scale-100"
                    x-transition:leave-end="transform opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50 origin-top-right"
                    style="display: none;">
                    
                    <div class="px-4 py-3 border-b border-gray-100">
                        <p class="text-sm font-semibold text-gray-800 truncate">{{ $user->detail?->full_name }}</p>
                        <p class="text-xs text-gray-500 truncate">{{ $user->email }}</p>
                    </div>
                    
                    <div class="py-1">
                        <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
                            <i class="fas fa-user-circle w-5 text-gray-400 mr-3"></i>
                            <span>My Profile</span>
                        </a>
                        
                        <a href="#" class="flex items-center px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
                            <i class="fas fa-cog w-5 text-gray-400 mr-3"></i>
                            <span>Settings</span>
                        </a>
                    </div>
                    
                    <div class="border-t border-gray-100"></div>
                    
                    <div class="py-1">
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">
                                <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                                <span>Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="bg-gradient-to-r from-purple-50 to-pink-50 border-t border-gray-100">
        <div class="flex items-center justify-between px-6 py-3">
            <div class="text-sm text-gray-600 flex items-center space-x-4">
                <span class="flex items-center">
                    <i class="far fa-calendar-alt mr-2 text-purple-600"></i>
                    <span id="current-date">Loading...</span>
                </span>
                <span class="text-gray-300">|</span>
                <span class="flex items-center">
                    <i class="far fa-clock mr-2 text-purple-600"></i>
                    <span id="current-time">Loading...</span>
                </span>
            </div>
        </div>
    </div>
</header>

@push('scripts')
    <script>
    function toggleDropdown() {
        const dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('hidden');
    }

    // Close dropdown when clicking outside
    window.addEventListener('click', function(e) {
        const dropdown = document.getElementById('userDropdown');
        const button = e.target.closest('button');
        
        if (!button || button.getAttribute('onclick') !== 'toggleDropdown()') {
            dropdown.classList.add('hidden');
        }
    });
</script>
@endpush
