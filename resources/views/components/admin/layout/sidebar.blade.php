@props([
    'user' => [
        'name' => 'Admin User',
        'role' => 'Administrator',
        'initials' => 'AU'
    ],
    'activeItem' => 'dashboard',
    'notifications' => ['users' => 0, 'courses' => 0]
])

<div id="sidebar" class="sidebar">

    
    <!-- User Profile Section -->
    <div class="p-6 border-b border-white/20">
        <div class="flex items-center space-x-3">
            <div class="w-12 h-12 bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-full flex items-center justify-center shadow-lg">
                <span class="text-white font-bold text-lg">{{ $user['initials'] }}</span>
            </div>
            <div>
                <h3 class="text-white font-semibold">{{ $user['name'] }}</h3>
                <p class="text-xs text-yellow-200">{{ $user['role'] }}</p>
            </div>
        </div>
    </div>
    
    <!-- Navigation Menu -->
    <nav class="mt-6 px-3">
        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}" 
           class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-lg mb-2 {{ $activeItem === 'dashboard' ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt sidebar-icon mr-3 text-lg"></i>
            <span>Dashboard</span>
        </a>
        
        <!-- Students -->
        <a href="{{ route('admin.students') }}" 
           class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-lg mb-2 {{ $activeItem === 'students' ? 'active' : '' }}">
            <i class="fas fa-users sidebar-icon mr-3 text-lg"></i>
            <span>Students</span>
            @if($notifications['users'] > 0)
                <span class="notification-badge ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                    {{ $notifications['users'] }}
                </span>
            @endif
        </a>
        
        <!-- Instructors -->
        <a href="{{ route('admin.instructors') }}" 
           class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-lg mb-2 {{ $activeItem === 'instructors' ? 'active' : '' }}">
            <i class="fas fa-chalkboard-teacher sidebar-icon mr-3 text-lg"></i>
            <span>Instructors</span>
        </a>
        
        <!-- Courses -->
        <a href="{{ route('admin.courses') }}" 
           class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-lg mb-2 {{ $activeItem === 'courses' ? 'active' : '' }}">
            <i class="fas fa-book sidebar-icon mr-3 text-lg"></i>
            <span>Courses</span>
            @if($notifications['courses'] > 0)
                <span class="notification-badge ml-auto bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                    {{ $notifications['courses'] }}
                </span>
            @endif
        </a>
        
        <!-- Reports -->
        <a href="#" 
           class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-lg mb-2 {{ $activeItem === 'reports' ? 'active' : '' }}">
            <i class="fas fa-chart-bar sidebar-icon mr-3 text-lg"></i>
            <span>Reports</span>
        </a>
        
        <!-- Settings -->
        <a href="#" 
           class="sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-lg mb-2 {{ $activeItem === 'settings' ? 'active' : '' }}">
            <i class="fas fa-cog sidebar-icon mr-3 text-lg"></i>
            <span>Settings</span>
        </a>
    </nav>
    
    <!-- Bottom Section -->
    <div class="absolute bottom-0 left-0 right-0 p-6 border-t border-white/20">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full sidebar-item flex items-center px-4 py-3 text-sm font-medium rounded-lg text-white hover:bg-white/10 transition-all duration-200">
                <i class="fas fa-sign-out-alt sidebar-icon mr-3 text-lg"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>

<!-- Mobile Menu Button -->
<button class="md:hidden fixed top-4 left-4 z-50 bg-white/90 backdrop-blur-sm rounded-lg p-2 shadow-lg" onclick="toggleSidebar()">
    <i class="fas fa-bars text-gray-700"></i>
</button>