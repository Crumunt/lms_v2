@props([
    'user',
    'message' => 'You have 3 assignments to grade and 2 upcoming classes.',
    'showCreateCourse' => true,
    'showViewAnalytics' => true
])

<div class="welcome-card">
    <div class="relative z-10">
        <h2 class="text-3xl font-bold mb-2">Welcome Back, {{ $user->detail?->full_name }}! 👨‍🏫</h2>
        <p class="text-white text-opacity-90 mb-4">{{ $message }}</p>
        <div class="flex flex-wrap gap-4">
            @if($showCreateCourse)
                <button class="btn-primary" onclick="window.location.href='{{ route('instructor.courses.create') }}'">
                    <i class="fas fa-plus-circle mr-2"></i>
                    Create New Course
                </button>
            @endif
            @if($showViewAnalytics)
                <button class="bg-white bg-opacity-20 backdrop-blur text-white px-6 py-3 rounded-xl font-semibold hover:bg-opacity-30 transition" onclick="window.location.href='{{ route('instructor.analytics') }}'">
                    <i class="fas fa-chart-bar mr-2"></i>
                    View Analytics
                </button>
            @endif
        </div>
    </div>
</div>
