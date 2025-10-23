@props([
    'user',
    'message',
    'showContinueLearning' => true,
    'showViewProgress' => true
])

<div class="welcome-card">
    <div class="relative z-10">
        <h2 class="text-3xl font-bold mb-2">Welcome Back, {{ $user->detail?->full_name }}! 👋</h2>
        <p class="text-white text-opacity-90 mb-4">{{ $message }}</p>
        <div class="flex flex-wrap gap-4">
            @if($showContinueLearning)
                <button class="btn-primary">
                    <i class="fas fa-play-circle mr-2"></i>
                    Continue Learning
                </button>
            @endif
            @if($showViewProgress)
                <button class="bg-white bg-opacity-20 backdrop-blur text-white px-6 py-3 rounded-xl font-semibold hover:bg-opacity-30 transition">
                    <i class="fas fa-chart-bar mr-2"></i>
                    View Progress
                </button>
            @endif
        </div>
    </div>
</div>
