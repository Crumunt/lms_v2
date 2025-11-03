@props([
    'assignments'
])

@php
    // Helper function to determine assignment urgency and styling
    function getAssignmentStyle($assignment)
    {
        $now = now();
        $dueDate = $assignment->due_date ? \Carbon\Carbon::parse($assignment->due_date) : null;

        if (!$dueDate) {
            return [
                'bgLight' => 'bg-gray-50',
                'borderColor' => 'border-gray-200',
                'bgColor' => 'bg-gray-500',
                'dueColor' => 'text-gray-600',
                'badgeColor' => 'bg-gray-100 text-gray-700',
                'badge' => 'No Due Date',
                'daysLeft' => null
            ];
        }

        $daysLeft = $now->diffInDays($dueDate, false);
        $hoursLeft = $now->diffInHours($dueDate, false);

        // Overdue
        if ($dueDate->isPast()) {
            return [
                'bgLight' => 'bg-red-50',
                'borderColor' => 'border-red-200',
                'bgColor' => 'bg-red-500',
                'dueColor' => 'text-red-600',
                'badgeColor' => 'bg-red-100 text-red-700',
                'badge' => 'Overdue',
                'daysLeft' => $daysLeft
            ];
        }

        // Due today or within 24 hours
        if ($hoursLeft <= 24) {
            return [
                'bgLight' => 'bg-orange-50',
                'borderColor' => 'border-orange-200',
                'bgColor' => 'bg-orange-500',
                'dueColor' => 'text-orange-600',
                'badgeColor' => 'bg-orange-100 text-orange-700',
                'badge' => $hoursLeft <= 6 ? 'Due Very Soon!' : 'Due Today',
                'daysLeft' => $daysLeft
            ];
        }

        // Due within 3 days
        if ($daysLeft <= 3) {
            return [
                'bgLight' => 'bg-yellow-50',
                'borderColor' => 'border-yellow-200',
                'bgColor' => 'bg-yellow-500',
                'dueColor' => 'text-yellow-600',
                'badgeColor' => 'bg-yellow-100 text-yellow-700',
                'badge' => 'Due Soon',
                'daysLeft' => $daysLeft
            ];
        }

        // Due within a week
        if ($daysLeft <= 7) {
            return [
                'bgLight' => 'bg-blue-50',
                'borderColor' => 'border-blue-200',
                'bgColor' => 'bg-blue-500',
                'dueColor' => 'text-blue-600',
                'badgeColor' => 'bg-blue-100 text-blue-700',
                'badge' => 'This Week',
                'daysLeft' => $daysLeft
            ];
        }

        // More than a week away
        return [
            'bgLight' => 'bg-green-50',
            'borderColor' => 'border-green-200',
            'bgColor' => 'bg-green-500',
            'dueColor' => 'text-green-600',
            'badgeColor' => 'bg-green-100 text-green-700',
            'badge' => 'Upcoming',
            'daysLeft' => $daysLeft
        ];
    }
@endphp

<section>
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-800">
            <i class="fas fa-calendar-check mr-3 text-red-600"></i>
            Upcoming Assignments
        </h2>
        @if($assignments->count() > 5)
            <a href="{{ route('student.assignments.index') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                View All
            </a>
        @endif
    </div>
    
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="p-6">
            <div class="space-y-4">
                @forelse($assignments as $assignment)
                    @php
                        $style = getAssignmentStyle($assignment);
                        $dueDate = $assignment->due_date ? \Carbon\Carbon::parse($assignment->due_date) : null;
                    @endphp
                    <div class="flex items-center space-x-4 p-4 rounded-xl {{ $style['bgLight'] }} border {{ $style['borderColor'] }} hover:shadow-md transition">
                        <div class="w-12 h-12 {{ $style['bgColor'] }} rounded-full flex flex-col items-center justify-center text-white font-bold flex-shrink-0">
                            @if($dueDate)
                                <span class="text-xs leading-none">{{ $dueDate->format('M') }}</span>
                                <span class="text-lg leading-none">{{ $dueDate->format('d') }}</span>
                            @else
                                <i class="fas fa-calendar-times"></i>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800 truncate">{{ $assignment->title }}</p>
                            <p class="text-xs text-gray-600 truncate">
                                <i class="fas fa-book mr-1"></i>
                                {{ $assignment->course->code }} - {{ $assignment->course->title }}
                            </p>
                            @if($dueDate)
                                <p class="text-xs {{ $style['dueColor'] }} font-medium mt-1">
                                    <i class="far fa-clock mr-1"></i>
                                    Due {{ $dueDate->format('M d, Y') }} at {{ $dueDate->format('g:i A') }}
                                    <span class="text-gray-400 ml-1">({{ $dueDate->diffForHumans() }})</span>
                                </p>
                            @else
                                <p class="text-xs text-gray-500 mt-1">
                                    <i class="far fa-clock mr-1"></i>
                                    No due date set
                                </p>
                            @endif
                        </div>
                        <div class="text-right flex-shrink-0">
                            <span class="inline-block {{ $style['badgeColor'] }} text-xs px-3 py-1 rounded-full font-medium mb-2">
                                {{ $style['badge'] }}
                            </span>
                            <div class="text-xs text-gray-500 mt-2">
                                <i class="fas fa-star text-amber-500 mr-1"></i>
                                {{ $assignment->total_points }} pts
                            </div>
                            <a href="" 
                               class="inline-block text-xs text-blue-600 hover:text-blue-700 font-medium mt-2">
                                View Details →
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <i class="fas fa-clipboard-list text-gray-300 text-5xl mb-3"></i>
                        <p class="text-sm font-medium text-gray-600 mb-1">No Upcoming Assignments</p>
                        <p class="text-xs text-gray-500">You're all caught up! Check back later for new assignments.</p>
                    </div>
                @endforelse
            </div>
        </div>
        
        @if($assignments->count() > 0)
            <div class="border-t border-gray-100 px-6 py-4 bg-gray-50">
                <div class="flex items-center justify-between text-xs text-gray-600">
                    <span>
                        <i class="fas fa-info-circle mr-1"></i>
                        Showing {{ $assignments->count() }} assignment(s)
                    </span>
                </div>
            </div>
        @endif
    </div>
</section>