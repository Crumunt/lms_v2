@props([
    'actions' => [
        [
            'icon' => 'fas fa-plus',
            'color' => 'blue',
            'label' => 'Create Course',
            'route' => 'instructor.course.create'
        ],
        [
            'icon' => 'fas fa-tasks',
            'color' => 'green',
            'label' => 'New Assignment',
            'route' => 'instructor.assignment.create'
        ],
        [
            'icon' => 'fas fa-users',
            'color' => 'purple',
            'label' => 'Manage Students',
            'route' => 'instructor.students'
        ],
        [
            'icon' => 'fas fa-chart-bar',
            'color' => 'orange',
            'label' => 'View Analytics',
            'route' => 'instructor.analytics'
        ],
        [
            'icon' => 'fas fa-calendar',
            'color' => 'red',
            'label' => 'Schedule',
            'route' => 'instructor.schedule'
        ],
        [
            'icon' => 'fas fa-cog',
            'color' => 'indigo',
            'label' => 'Settings',
            'route' => 'instructor.settings'
        ]
    ]
])

<section class="mb-8">
    <h2 class="text-xl font-bold text-gray-800 mb-6">
        <i class="fas fa-bolt mr-3 text-yellow-600"></i>
        Quick Actions
    </h2>
    
    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @foreach($actions as $action)
            <button class="bg-white rounded-xl p-6 shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-300 hover:-translate-y-1 group" onclick="window.location.href='{{ route($action['route']) }}'">
                <div class="w-12 h-12 bg-{{ $action['color'] }}-100 rounded-full flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition">
                    <i class="{{ $action['icon'] }} text-{{ $action['color'] }}-600 text-xl"></i>
                </div>
                <p class="text-sm font-medium text-gray-700 text-center">{{ $action['label'] }}</p>
            </button>
        @endforeach
    </div>
</section>
