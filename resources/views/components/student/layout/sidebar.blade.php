@props([
    'user' => [
        'name' => 'Francis',
        'program' => 'BS Computer Science',
        'initials' => 'JD',
        'avatar' => null
    ],
    'activeItem' => 'dashboard',
    'notifications' => [
        'courses' => 5,
        'assignments' => 2
    ]
])

<div id="sidebar" class="sidebar">

               <div class="flex flex-col items-center px-6 py-6 border-b border-white border-opacity-20">
        <div class="logo-container w-24 h-24 bg-white bg-opacity-10 rounded-2xl flex items-center justify-center mb-4 backdrop-blur-sm">
            <i class="fas fa-university text-4xl text-white"></i>
        </div>
        <div class="text-center">
    <h1 class="text-xl font-bold tracking-wide">CLSU</h1>
            <p class="text-xs opacity-80 mt-1">L
           earning Management System</p>
        </div>
    </div>
    
    <nav class="flex-1 px-3 py-6 space-y-2" aria-label="Main Navigation">
        <a href="{{ route('student.dashboard') }}" class="flex items-center px-4 py-3 text-white sidebar-item {{ Route::currentRouteName() === 'student.dashboard' ? 'active' : '' }}">
        <div clas
        s       ="sidebar-icon bg-white bg-opacity-20 w-10 h-10 rounded-xl flex items-center justify-center">
                <i class="fas fa-home"></i>
            </div>
            <span class="ml-4 font-medium">Dashboard</span>
        </a>

                   
        <a href="{{ route('student.courses') }}" class="flex items-center px-4 py-3 text-white sidebar-item {{ Route::currentRouteName() === 'student.courses' ? 'active' : '' }}">
            <div class="sidebar-icon bg-white bg-opacity-20 w-10 h-10 rounded-xl flex items-center justify-center">
                <i class="fas fa-book-open"></i>
            </div>
    <span class="ml-4 font-medium">My Courses</span>
            @if($notifications['courses'] > 0)

                   <span class="ml-auto notification-badge bg-red-500 text-white text-xs px-2 py-1 rounded-full">{{ $notifications['courses'] }}</span>
            @endif
        </a>

        <a href="{{ route('student.catalog') }}" class="flex items-center px-4 py-3 text-white sidebar-item {{ Route::currentRouteName() === 'student.catalog' ? 'active' : '' }}">
            <div class="sidebar-icon bg-white bg-opacity-20 w-10 h-10 rounded-xl flex items-center justify-center">
            <i class="fas fa-th-list"></i>
            </div>
            <span class="ml-4 font-medium">Course Catalog</span>
        </a>

                       
        <a href="{{ route('student.resources') }}" class="flex items-center px-4 py-3 text-white sidebar-item {{ Route::currentRouteName() === 'student.resources' ? 'active' : '' }}">
            <div class="sidebar-icon bg-white bg-opacity-20 w-10 h-10 rounded-xl flex items-center justify-center">
                <i class="fas fa-folder"></i>
            </div>
            <span class="ml-4 font-medium">Resources</span>
        </a>
    </nav>
    
    <div class="p-4 border-t border-white border-opacity-20">
        <div class="flex items-center p-3 rounded-xl hover:bg-white hover:bg-opacity-10 transition cursor-pointer">
            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-yellow-400 to-orange-400 flex items-center justify-center font-bold text-white shadow-lg">
                {{ $user['initials'] }}
            </div>
            <div class="ml-3 flex-1">
                <p class="text-sm font-semibold">{{ $user['name'] }}</p>
                <p class="text-xs opacity-70">{{ $user['program'] }}</p>
            </div>
        </div>
    </div>
</div>
