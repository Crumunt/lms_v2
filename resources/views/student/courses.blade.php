@extends('layouts.student')

@section('content')
    <!-- Page Header -->
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">My Courses</h1>
            <p class="text-gray-600">Manage and track your enrolled courses</p>
        </div>
        <a class="btn-secondary" href="{{ route('student.catalog') }}">
            <i class="fas fa-plus mr-2"></i>
            Browse More Courses
        </a>
    </div>

    <!-- Courses Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($enrolledCourses as $course)
            <div class="course-card" onclick="window.location.href='{{ route('student.course.show', $course->id) }}'">
                <div class="course-image flex items-center justify-center">
                    <i class="fas fa-book text-6xl text-white opacity-80"></i>
                    <div class="course-badge">{{ $course->code }}</div>
                </div>
                <div class="course-content">
                    <h3 class="text-lg font-bold text-gray-800 mb-2">{{ $course['title'] }}</h3>
                    <p class="text-gray-600 text-sm mb-2">{{ $course['description'] }}</p>
                    <p class="text-gray-500 text-xs mb-4">
                        <i class="fas fa-chalkboard-teacher mr-1"></i>
                        {{ $course->instructor?->detail?->full_name }}
                    </p>

                    <div class="flex items-center justify-between mt-4">
                        <div class="flex items-center space-x-4 text-xs text-gray-500">
                            <span>
                                <i class="fas fa-calendar mr-1"></i>
                                Enrolled: {{ date_format($course->pivot->created_at, 'Y, M d') }}
                            </span>
                        </div>
                        <div class="space-x-2">
                            <button class="btn-primary text-sm px-4 py-2"
                                onclick="event.stopPropagation(); window.location.href='{{ route('student.course.show', $course->id) }}'">
                                <i class="fas fa-eye mr-1"></i>
                                View Course
                            </button>
                            <button class="btn-secondary text-sm px-4 py-2"
                                onclick="event.stopPropagation(); unenrollFromCourse({{ $course->id }})">
                                <i class="fas fa-times mr-1"></i>
                                Unenroll
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Empty State (if no courses) -->
    @if(empty($enrolledCourses))
        <div class="text-center py-12">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-book text-4xl text-gray-400"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">No courses enrolled</h3>
            <p class="text-gray-600 mb-6">Start your learning journey by enrolling in courses</p>
            <a class="btn-primary" href="{{ route('student.catalog') }}">
                <i class="fas fa-search mr-2"></i>
                Browse Courses
            </a>
        </div>
    @endif

    @push('scripts')    
    <script>
        function unenrollFromCourse(courseId) {
            if (confirm('Are you sure you want to unenroll from this course?')) {
                fetch(`/student/courses/${courseId}/unenroll`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification(data.message, 'success');
                            setTimeout(() => {
                                window.location.href = '/student/catalog';
                            }, 1000);
                        } else {
                            showNotification(data.message, 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Failed to unenroll. Please try again.', 'error');
                    });
            }
        }

        function showNotification(message, type) {
            const notification = document.createElement('div');
            notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300 ${type === 'success' ? 'bg-green-500 text-white' :
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

@endsection