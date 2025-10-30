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
    @livewire('student.student-course-catalog', ['isEnroll' => false])

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