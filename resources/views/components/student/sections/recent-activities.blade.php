@props([
    'activities' => [
        [
            'type' => 'completed',
            'icon' => 'fas fa-check',
            'iconBg' => 'bg-green-100',
            'iconColor' => 'text-green-600',
            'title' => 'Completed Assignment',
            'description' => 'Programming Exercise 3 - Introduction to Programming',
            'time' => '2 hours ago'
        ],
        [
            'type' => 'video',
            'icon' => 'fas fa-video',
            'iconBg' => 'bg-blue-100',
            'iconColor' => 'text-blue-600',
            'title' => 'Watched Video',
            'description' => 'Database Normalization - Database Management',
            'time' => '4 hours ago'
        ],
        [
            'type' => 'comment',
            'icon' => 'fas fa-comment',
            'iconBg' => 'bg-purple-100',
            'iconColor' => 'text-purple-600',
            'title' => 'Posted Comment',
            'description' => 'Computer Networks Discussion Forum',
            'time' => '1 day ago'
        ],
        [
            'type' => 'download',
            'icon' => 'fas fa-download',
            'iconBg' => 'bg-orange-100',
            'iconColor' => 'text-orange-600',
            'title' => 'Downloaded Resource',
            'description' => 'Mobile App Development - React Native Guide',
            'time' => '2 days ago'
        ]
    ]
])

<section>
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-800">
            <i class="fas fa-history mr-3 text-blue-600"></i>
            Recent Activities
        </h2>
        <button class="text-sm text-green-600 hover:text-green-700 font-medium">
            View All
        </button>
    </div>
    
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="p-6">
            <div class="space-y-4">
               @forelse($activities as $activity)
                <div class="flex items-start space-x-4 p-4 rounded-xl hover:bg-gray-50 transition">
                    <div class="w-10 h-10 {{ $activity['iconBg'] }} rounded-full flex items-center justify-center">
                        <i class="{{ $activity['icon'] }} {{ $activity['iconColor'] }}"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-800">{{ $activity['title'] }}</p>
                        <p class="text-xs text-gray-500">{{ $activity['description'] }}</p>
                        <p class="text-xs text-gray-400 mt-1">{{ $activity['time'] }}</p>
                    </div>
                </div>
            @empty
                <div class="p-4 text-sm text-gray-500 text-center">
                    No recent activities to show.
                </div>
            @endforelse

            </div>
        </div>
    </div>
</section>
