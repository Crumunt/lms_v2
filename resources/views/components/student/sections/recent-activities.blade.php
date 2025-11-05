@props([
    'activities' => collect([])
])

@php
    // Helper function to get activity icon and colors based on log_name or description
    function getActivityStyle($activity)
    {
        $logName = strtolower($activity->log_name ?? '');
        $description = strtolower($activity->description ?? '');

        // Check log_name or description for keywords
        if (str_contains($logName, 'enrollment') || str_contains($description, 'enrolled')) {
            return [
                'icon' => 'fas fa-user-plus',
                'iconBg' => 'bg-green-100',
                'iconColor' => 'text-green-600',
            ];
        } elseif (str_contains($logName, 'assignment') || str_contains($description, 'assignment')) {
            return [
                'icon' => 'fas fa-clipboard-check',
                'iconBg' => 'bg-blue-100',
                'iconColor' => 'text-blue-600',
            ];
        } elseif (str_contains($logName, 'graded') || str_contains($description, 'graded')) {
            return [
                'icon' => 'fas fa-star',
                'iconBg' => 'bg-yellow-100',
                'iconColor' => 'text-yellow-600',
            ];
        } elseif (str_contains($logName, 'upload') || str_contains($description, 'uploaded')) {
            return [
                'icon' => 'fas fa-upload',
                'iconBg' => 'bg-purple-100',
                'iconColor' => 'text-purple-600',
            ];
        } elseif (str_contains($logName, 'download') || str_contains($description, 'downloaded')) {
            return [
                'icon' => 'fas fa-download',
                'iconBg' => 'bg-orange-100',
                'iconColor' => 'text-orange-600',
            ];
        } elseif (str_contains($logName, 'deleted') || str_contains($description, 'deleted')) {
            return [
                'icon' => 'fas fa-trash',
                'iconBg' => 'bg-red-100',
                'iconColor' => 'text-red-600',
            ];
        } elseif (str_contains($logName, 'updated') || str_contains($description, 'updated')) {
            return [
                'icon' => 'fas fa-edit',
                'iconBg' => 'bg-indigo-100',
                'iconColor' => 'text-indigo-600',
            ];
        } elseif (str_contains($logName, 'created') || str_contains($description, 'created')) {
            return [
                'icon' => 'fas fa-plus-circle',
                'iconBg' => 'bg-teal-100',
                'iconColor' => 'text-teal-600',
            ];
        } elseif (str_contains($logName, 'viewed') || str_contains($description, 'viewed')) {
            return [
                'icon' => 'fas fa-eye',
                'iconBg' => 'bg-cyan-100',
                'iconColor' => 'text-cyan-600',
            ];
        } else {
            return [
                'icon' => 'fas fa-circle',
                'iconBg' => 'bg-gray-100',
                'iconColor' => 'text-gray-600',
            ];
        }
    }
@endphp
<section>
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-800">
            <i class="fas fa-history mr-3 text-blue-600"></i>
            Recent Activities
        </h2>
    </div>
    
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
        <div class="p-6">
            <div class="space-y-4">
                @forelse($activities as $activity)
                    @php
                        $style = getActivityStyle($activity);
                    @endphp
                    <div class="flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-50 transition border border-gray-100 hover:shadow-md">
                        <div class="w-12 h-12 {{ $style['iconBg'] }} rounded-full flex items-center justify-center flex-shrink-0">
                            <i class="{{ $style['icon'] }} {{ $style['iconColor'] }} text-lg"></i>
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-semibold text-gray-800">{{ $activity->description }}</p>

                            @if($activity->properties && count($activity->properties) > 0)
                                <p class="text-xs text-gray-600 mt-1">
                                    @if(isset($activity->properties['course_name']))
                                        <i class="fas fa-book mr-1"></i>
                                        {{ $activity->properties['course_name'] }}
                                    @endif

                                    @if(isset($activity->properties['course_code']))
                                        <span class="text-gray-500"> - {{ $activity->properties['course_code'] }}</span>
                                    @endif
                                </p>
                            @endif

                            <p class="text-xs text-gray-500 font-medium mt-1">
                                <i class="far fa-clock mr-1"></i>
                                {{ $activity->created_at->diffForHumans() }}
                                @if($activity->subject_type && $activity->subject_id)
                                    <span class="text-gray-400 mx-1">•</span>
                                    <span class="text-gray-400">
                                        {{ class_basename($activity->subject_type) }}
                                    </span>
                                @endif
                            </p>
                        </div>

                        @if($activity->subject)
                            <div class="text-right flex-shrink-0">
                                @php
                                    $subjectType = class_basename($activity->subject_type);
                                @endphp

                                @if($subjectType === 'Course')
                                    <a href="{{ route('student.course.show', $activity->subject_id) }}" 
                                       class="inline-block text-xs text-blue-600 hover:text-blue-700 font-medium">
                                        View Details →
                                    </a>
                                @elseif($subjectType === 'Assignment')
                                    <a href="{{ route('assignments.show', $activity->subject_id) }}" 
                                       class="inline-block text-xs text-blue-600 hover:text-blue-700 font-medium">
                                        View Details →
                                    </a>
                                @endif
                            </div>
                        @endif
                    </div>
                @empty
                    <div class="p-8 text-center">
                        <i class="fas fa-inbox text-gray-300 text-5xl mb-3"></i>
                        <p class="text-sm font-medium text-gray-600 mb-1">No Recent Activities</p>
                        <p class="text-xs text-gray-500">Your activities will appear here as you use the platform.</p>
                    </div>
                @endforelse
            </div>
        </div>
        
        @if($activities->count() > 0)
            <div class="border-t border-gray-100 px-6 py-4 bg-gray-50">
                <div class="flex items-center justify-between text-xs text-gray-600">
                    <span>
                        <i class="fas fa-info-circle mr-1"></i>
                        Showing {{ $activities->count() }} activitie(s)
                    </span>
                </div>
            </div>
        @endif
    </div>
</section>