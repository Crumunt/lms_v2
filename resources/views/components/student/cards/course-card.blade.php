@props([
    'course',
    'isEnroll' => true
])

<div class="course-card" wire:key="course-{{ $course->id }}">
    <div class="course-image flex items-center justify-center">
        <i class="{{'fas fa-book' }} text-6xl text-white opacity-80"></i>
        <div class="course-badge">{{ $course->code }}</div>
    </div>
    <div class="course-content">
        <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $course->title }}</h3>
        <p class="text-gray-600 text-sm mb-2">{{ $course->description }}</p>
        
        @if(isset($course->instructor->detail->full_name))
            <p class="text-gray-500 text-xs mb-4">
                <i class="fas fa-chalkboard-teacher mr-1"></i>
                {{ $course->instructor->detail->full_name }}
            </p>
        @endif
        
        <div class="flex items-center justify-between mt-4">
            <div class="flex items-center space-x-4 text-xs text-gray-500">
                @if ($isEnroll)    
                    <span>
                        <i class="fas fa-users mr-1"></i>
                        {{ $course->enrollment_count ?? 0 }} students
                    </span>
                    <span>
                     <i class="fas fa-signal mr-1"></i>
                        {{ ucfirst($course->difficulty) }}
                    </span>
                 @else
                    <div class="flex items-center space-x-4 text-xs text-gray-500">
                        <span>
                            <i class="fas fa-calendar mr-1"></i>
                            Enrolled: {{ $course->pivot?->created_at ? date_format($course->pivot->created_at, 'Y, M d') : 'N/A' }}
                        </span>
                    </div>
                 @endif
            </div>
            <div class="space-x-2">
                @if($isEnroll)
                    <!-- Available course (catalog) -->
                    @can('enroll', [\App\Models\Enrollment::class, $course])
                        <button class="btn-primary text-sm px-4 py-2" wire:click="enroll('{{ $course->id }}')"
                        wire:loading.attr="disabled"
                        wire:target="enroll('{{ $course->id }}')"
                    >
                        <span wire:loading.remove wire:target="enroll('{{ $course->id }}')">
                            <i class="fas fa-plus mr-1"></i>
                            Enroll
                        </span>
                        <span wire:loading wire:target="enroll('{{ $course->id }}')">
                            <i class="fas fa-spinner fa-spin mr-1"></i>
                            Enrolling...
                        </span>
                    </button>
                    @endcan
                @else
                    <!-- Enrolled course (dashboard/courses) -->
                    <button class="btn-primary text-sm px-4 py-2" onclick="event.stopPropagation(); window.location.href='{{ route('student.course.show', $course['id']) }}'">
                        <i class="fas fa-eye mr-1"></i>
                        View
                    </button>
                    @can('unenroll', [\App\Models\Enrollment::class, $course->enrollments])
                        <button class="btn-secondary text-sm px-4 py-2" wire:click="cancelEnrollment('{{ $course->id }}')"
                        wire:loading.attr="disabled"
                        wire:target="cancelEnrollment('{{ $course->id }}')"
                    >
                            <span wire:loading.remove wire:target="cancelEnrollment('{{ $course->id }}')">
                                <i class="fas fa-times mr-1"></i>
                                Unenroll
                            </span>

                            <span wire:loading wire:target="cancelEnrollment('{{ $course->id }}')">
                                <i class="fas fa-spinner fa-spin mr-1"></i>
                                Removing...
                            </span>
                        </button>
                    @endcan
                @endif
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function showNotification(message, type) {
    const notification = document.createElement('div');
    notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300 ${
        type === 'success' ? 'bg-green-500 text-white' : 
        type === 'error' ? 'bg-red-500 text-white' : 
        'bg-blue-500 text-white'
    }`;
    notification.textContent = message;
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    setTimeout(() => {
        notification.style.transform = 'translateX(100%)';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}
</script>
@endpush
