@props([
    'events' => [
        [
            'day' => '15',
            'bgColor' => 'bg-red-500',
            'borderColor' => 'border-red-100',
            'bgLight' => 'bg-red-50',
            'title' => 'Database Quiz',
            'description' => 'Database Management - CS 201',
            'dueDate' => 'Due: Tomorrow, 2:00 PM',
            'dueColor' => 'text-red-600',
            'badge' => 'Urgent',
            'badgeColor' => 'bg-red-100 text-red-800'
        ],
        [
            'day' => '18',
            'bgColor' => 'bg-yellow-500',
            'borderColor' => 'border-yellow-100',
            'bgLight' => 'bg-yellow-50',
            'title' => 'Programming Assignment',
            'description' => 'Introduction to Programming - CS 101',
            'dueDate' => 'Due: Jan 18, 11:59 PM',
            'dueColor' => 'text-yellow-600',
            'badge' => '3 days',
            'badgeColor' => 'bg-yellow-100 text-yellow-800'
        ],
        [
            'day' => '20',
            'bgColor' => 'bg-blue-500',
            'borderColor' => 'border-blue-100',
            'bgLight' => 'bg-blue-50',
            'title' => 'Midterm Exam',
            'description' => 'Computer Networks - CS 301',
            'dueDate' => 'Jan 20, 9:00 AM',
            'dueColor' => 'text-blue-600',
            'badge' => '5 days',
            'badgeColor' => 'bg-blue-100 text-blue-800'
        ],
        [
            'day' => '22',
            'bgColor' => 'bg-green-500',
            'borderColor' => 'border-green-100',
            'bgLight' => 'bg-green-50',
            'title' => 'Project Presentation',
            'description' => 'Mobile App Development - CS 401',
            'dueDate' => 'Jan 22, 1:00 PM',
            'dueColor' => 'text-green-600',
            'badge' => '1 week',
            'badgeColor' => 'bg-green-100 text-green-800'
        ]
    ]
])

<section>
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-800">
            <i class="fas fa-calendar-check mr-3 text-red-600"></i>
            Upcoming Events
        </h2>
        <button class="text-sm text-green-600 hover:text-green-700 font-medium">
            View Calendar
        </button>
    </div>
    
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="p-6">
            <div class="space-y-4">
                @forelse($events as $event)
                    <div class="flex items-center space-x-4 p-4 rounded-xl {{ $event['bgLight'] }} border {{ $event['borderColor'] }}">
                        <div class="w-12 h-12 {{ $event['bgColor'] }} rounded-full flex items-center justify-center text-white font-bold">
                            {{ $event['day'] }}
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800">{{ $event['title'] }}</p>
                            <p class="text-xs text-gray-500">{{ $event['description'] }}</p>
                            <p class="text-xs {{ $event['dueColor'] }} font-medium">{{ $event['dueDate'] }}</p>
                        </div>
                        <div class="text-right">
                            <span class="inline-block {{ $event['badgeColor'] }} text-xs px-2 py-1 rounded-full">{{ $event['badge'] }}</span>
                        </div>
                    </div>
                @empty
                    <div class="p-4 text-sm text-gray-500 text-center">
                        No recent events to show.
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>
