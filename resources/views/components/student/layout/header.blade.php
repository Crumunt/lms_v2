@props([
    'user' => ['name' => 'John'],
    'currentDate' => null,
    'currentTime' => null,
    'semester' => '1st Sem 2025-2026'
])

<header class="header glass-effect">
    <div class="flex items-center justify-between px-6 py-4">
        <div class="flex items-center">
            <button id="menu-toggle" class="mr-4 text-gray-700 hover:text-gray-900 lg:hidden transition" onclick="toggleSidebar()">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <div>
                <h1 class="text-2xl font-bold bg-gradient-to-r from-green-700 to-green-500 bg-clip-text text-transparent">
                    Student Dashboard
                </h1>
                <p class="text-sm text-gray-500 mt-1">Welcome back, {{ $user->detail?->full_name }}!</p>
            </div>
        </div>
        
        <div class="flex items-center space-x-4">
            <div class="relative hidden md:block">
                <input type="text" placeholder="Search courses, topics..." 
                       class="search-input py-2.5 pl-12 pr-4 w-80 border border-gray-200 rounded-xl focus:outline-none text-sm">
                <i class="fas fa-search absolute left-4 top-3 text-gray-400"></i>
            </div>
            
            <button class="relative p-2.5 rounded-xl hover:bg-gray-100 transition">
                <i class="fas fa-bell text-gray-600 text-lg"></i>
                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
            
            <button class="p-2.5 rounded-xl hover:bg-gray-100 transition">
                <i class="fas fa-envelope text-gray-600 text-lg"></i>
            </button>
        </div>
    </div>
    
    <div class="bg-gradient-to-r from-green-50 to-emerald-50 border-t border-gray-100">
        <div class="flex items-center justify-between px-6 py-3">
            <div class="text-sm text-gray-600 flex items-center space-x-4">
                <span class="flex items-center">
                    <i class="far fa-calendar-alt mr-2 text-green-600"></i>
                    <span id="current-date">{{ $currentDate ?? 'Loading...' }}</span>
                </span>
                <span class="text-gray-300">|</span>
                <span class="flex items-center">
                    <i class="far fa-clock mr-2 text-green-600"></i>
                    <span id="current-time">{{ $currentTime ?? 'Loading...' }}</span>
                </span>
            </div>
        </div>
    </div>
</header>
