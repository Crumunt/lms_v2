@props([
    'user',
    'notifications'
])

<div id="sidebar" class="sidebar">

    
    <!-- User Profile Section -->
    <div class="p-6 border-b border-white/20">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center shadow-lg">
                <span class="text-white font-bold text-lg">{{ substr(strtoupper($user->detail?->full_name),0,2) }}</span>
            </div>
            <div>
                <h3 class="text-white font-semibold">{{ $user->detail?->full_name }}</h3>
                <p class="text-xs text-yellow-200">{{ $user->roles->first()->name }}</p>
            </div>
        </div>
    </div>
    
    <!-- Navigation Menu -->
    <nav class="mt-6 px-3">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" 
           class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-lg mb-2 {{ Route::currentRouteName() === 'admin.dashboard' ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt sidebar-icon mr-3 text-lg"></i>
            <span>Dashboard</span>
        </a>
        
        <!-- Students -->
        <a href="{{ route('admin.students') }}" 
           class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-lg mb-2 {{ Route::currentRouteName() === 'admin.students' ? 'active' : '' }}">
            <i class="fas fa-users sidebar-icon mr-3 text-lg"></i>
            <span>Students</span>
            @if($notifications['users'] > 0)
                <span class="notification-badge ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                    {{ $notifications['users'] }}
                </span>
            @endif
        </a>
        
        <!-- Instructors -->
        <a href="{{ route('admin.instructors.index') }}" 
           class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-lg mb-2 {{ Route::currentRouteName() === 'admin.instructors.index' ? 'active' : '' }}">
            <i class="fas fa-chalkboard-teacher sidebar-icon mr-3 text-lg"></i>
            <span>Instructors</span>
        </a>
        
        <!-- Courses -->
        <a href="{{ route('admin.courses') }}" 
           class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-lg mb-2 {{ Route::currentRouteName() === 'admin.courses' ? 'active' : '' }}">
            <i class="fas fa-book sidebar-icon mr-3 text-lg"></i>
            <span>Courses</span>
            @if($notifications['courses'] > 0)
                <span class="notification-badge ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                    {{ $notifications['courses'] }}
                </span>
            @endif
        </a>
    </nav>
</div>

<!-- Mobile Menu Button -->
<button class="md:hidden fixed top-4 left-4 z-50 bg-white/90 backdrop-blur-sm rounded-lg p-2 shadow-lg" onclick="toggleSidebar()">
    <i class="fas fa-bars text-gray-700"></i>
</button>