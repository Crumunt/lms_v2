@extends('layouts.student')

@section('content')
    <!-- Course Header -->
    <div class="bg-gradient-to-r from-green-600 to-green-500 text-white rounded-2xl p-8 mb-8">
        <div class="flex items-center space-x-6">
            <div class="w-20 h-20 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                <i class="fas fa-book text-4xl"></i>
            </div>
            <div class="flex-1">
                <h1 class="text-3xl font-bold mb-2">{{ $enrolledCourse->title }}</h1>
                <p class="text-green-100 text-lg">{{ $enrolledCourse->code }}</p>
                @if($enrolledCourse)
                    <div class="flex items-center mt-3">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        <span class="text-sm">Enrolled since {{ $enrolledCourse->pivot?->created_at }}</span>
                    </div>
                @endif
            </div>

        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
        <!-- Course Navigation Sidebar -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 sticky top-24">
                <h3 class="font-semibold text-gray-800 mb-4">Course Content</h3>

                <!-- Course Navigation -->
                <div class="space-y-2">
                    <a href="#overview"
                        class="course-nav-item active flex items-center px-4 py-3 rounded-xl transition-all duration-200 bg-green-50 text-green-700 border border-green-200">
                        <i class="fas fa-info-circle mr-3"></i>
                        <span>Course Overview</span>
                    </a>
                    <a href="#assignments"
                        class="course-nav-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 text-gray-600 hover:bg-gray-50 hover:text-gray-800">
                        <i class="fas fa-book mr-3"></i>
                        <span>Course Assignments</span>
                    </a>
                    <a href="#course-contents"
                        class="course-nav-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 text-gray-600 hover:bg-gray-50 hover:text-gray-800">
                        <i class="fas fa-list mr-3"></i>
                        <span>Learning Modules</span>
                    </a>
                </div>

                <!-- Enrollment Status -->
                <div class="mt-6 p-4 bg-blue-50 rounded-xl border border-blue-200">
                    <div class="text-center">
                        <i class="fas fa-graduation-cap text-blue-600 text-2xl mb-2"></i>
                        <p class="text-sm font-medium text-blue-800">Enrolled</p>
                        <p class="text-xs text-blue-600">Since {{ $enrolledCourse->pivot?->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content Area -->
        <div class="lg:col-span-3">
            <!-- Course Overview Section -->
            <div id="overview" class="course-section">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Course Overview</h3>

                    <!-- Course Description -->
                    <div class="mb-8">
                        <h4 class="font-semibold text-gray-700 mb-3">Description</h4>
                        <p class="text-gray-600 leading-relaxed">
                            {{ $enrolledCourse->description }}
                        </p>
                    </div>

                    <!-- Course Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="col-span-full bg-gray-50 rounded-xl p-6">
                            <h5 class="font-semibold text-gray-700 mb-4">Course Details</h5>
                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Level:</span>
                                    <span class="font-medium">Beginner</span>
                                </div>
                                <div class="flex justify-between">
                                    <h5 class="text-gray-700">Instructor:</h5>
                                    <div class="text-end">
                                        <div>
                                            <p class="font-medium text-gray-800">
                                                {{ $enrolledCourse->instructor?->detail?->full_name }}
                                            </p>
                                            <p class="text-xs text-gray-500">{{ $enrolledCourse->instructor?->email }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Materials Section -->
            <div id="assignments" class="course-section hidden">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Assignments</h3>

                    <div class="space-y-4">
                        <!-- Assignment 1 -->
                        @forelse ($assignments as $assignment)
                            <div class="bg-gray-50 border {{ $assignment->border_color }} rounded-xl p-6 hover:shadow-md transition">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <div class="flex items-center space-x-3 mb-2">
                                            <div class="w-10 h-10 {{ $assignment->icon_color }} rounded-lg flex items-center justify-center">
                                                <i class="fas fa-tasks"></i>
                                            </div>
                                            <div>
                                                <h5 class="font-semibold text-gray-800">{{ $assignment->title }}</h5>
                                                <div class="flex items-center space-x-4 mt-1">
                                                    <span class="text-xs text-gray-500">
                                                        <i class="far fa-calendar mr-1"></i>Due:
                                                        {{ $assignment->formatted_due_date }}
                                                    </span>
                                                    <span
                                                        class="px-2 py-1 {{ $assignment->status_badge['class'] }} rounded-full text-xs font-medium">
                                                        {{ $assignment->status_badge['text'] }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <p class="text-sm text-gray-600 mt-3 ml-13">
                                            {{ $assignment->description }}
                                        </p>
                                    </div>
                                    <a
                                        href="{{ route('student.course.assignment', [$enrolledCourse, $assignment]) }}"
                                        class="ml-4 px-4 py-2 {{ $assignment->icon_color }} {{ $assignment->border_color }} {{ $assignment->hover_color }} rounded-lg transition-colors text-sm font-medium whitespace-nowrap">
                                        View Details
                                    </a>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-16">
                                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                    <i class="fas fa-tasks text-gray-400 text-3xl"></i>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-700 mb-2">No Assignments Yet</h4>
                                <p class="text-gray-500 text-sm">
                                    Your instructor hasn't posted any assignments for this course yet.<br>
                                    Check back later or contact your instructor for more information.
                                </p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>

            <!-- Course Contents Section -->
            <div id="course-contents" class="course-section hidden">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Course Contents</h3>

                    <!-- Course Contents Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-4 px-4 text-sm font-semibold text-gray-700">Title</th>
                                    <th class="text-left py-4 px-4 text-sm font-semibold text-gray-700">Description</th>
                                    <th class="text-left py-4 px-4 text-sm font-semibold text-gray-700">Status</th>
                                    <th class="text-left py-4 px-4 text-sm font-semibold text-gray-700">Uploaded</th>
                                    <th class="text-left py-4 px-4 text-sm font-semibold text-gray-700">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse ($course_content as $content)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="py-4 px-4">
                                            <div class="flex items-center space-x-3">
                                                <i class="fas fa-file-video text-blue-600"></i>
                                                <span class="font-medium text-gray-800">{{ $content->title }}</span>
                                            </div>
                                        </td>
                                        <td class="py-4 px-4">
                                            <p class="text-sm text-gray-600">{{ $content->description }}</p>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span
                                                class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                                                {{ ucfirst($content->status) }}
                                            </span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <span
                                                class="text-sm text-gray-600">{{ $content->created_at->format('M d, Y') }}</span>
                                        </td>
                                        <td class="py-4 px-4">
                                            <div class="flex items-center space-x-2">
                                                <a href="{{ Storage::url($content->file_path) }}" target="_blank"
                                                    class="p-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors"
                                                    title="View">
                                                    <i class="fas fa-eye"></i>
                                                    View
                                                </a>
                                                <a href="{{ Storage::url($content->file_path) }}" download class="p-2 text-gray-600 hover:bg-gray-100 rounded-lg transition-colors"
                                                    title="Download">
                                                    <i class="fas fa-download"></i>
                                                    Download
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center py-12">
                                            <i class="fas fa-folder-open text-gray-300 text-5xl mb-4"></i>
                                            <h4 class="text-lg font-semibold text-gray-700 mb-2">No Content Yet</h4>
                                            <p class="text-gray-500 mb-4">Wait for instructors to upload course content</p>
                                        </td>
                                    </tr>
                                @endforelse

                            </tbody>
                        </table>
                    </div>

                    <!-- Empty State (hide when there are contents) -->
                    <!-- <div class="text-center py-12 hidden">
                                                        <i class="fas fa-folder-open text-gray-300 text-5xl mb-4"></i>
                                                        <h4 class="text-lg font-semibold text-gray-700 mb-2">No Content Yet</h4>
                                                        <p class="text-gray-500 mb-4">Start by uploading your first course content</p>
                                                        <button class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                                            Upload Content
                                                        </button>
                                                    </div> -->
                </div>
            </div>


        </div>
    </div>

    @push('styles')
        <style>
            .course-nav-item {
                transition: all 0.3s ease;
            }

            .course-nav-item:hover {
                background: rgba(6, 132, 6, 0.1);
                color: var(--clsu-green);
                transform: translateX(4px);
            }

            .course-nav-item.active {
                background: linear-gradient(135deg, var(--clsu-green), var(--clsu-light-green));
                color: white;
                box-shadow: 0 4px 12px rgba(6, 132, 6, 0.3);
            }

            .course-section {
                display: block;
            }

            .course-section.hidden {
                display: none;
            }

            .course-section {
                margin-top: 2rem;
            }

            .ml-13 {
                margin-left: 3.25rem;
            }

            table {
                border-collapse: separate;
                border-spacing: 0;
            }

            tbody tr:last-child td {
                border-bottom: none;
            }
        </style>
    @endpush

    @push('scripts')
        <script>
            // Course navigation functionality
            document.addEventListener('DOMContentLoaded', function () {
                const navItems = document.querySelectorAll('.course-nav-item');
                const sections = document.querySelectorAll('.course-section');

                navItems.forEach(item => {
                    item.addEventListener('click', function (e) {
                        e.preventDefault();
                        const targetSection = this.getAttribute('href').substring(1);

                        // Update active nav item
                        navItems.forEach(nav => nav.classList.remove('active'));
                        this.classList.add('active');

                        // Show target section
                        sections.forEach(section => {
                            section.classList.add('hidden');
                        });

                        const targetElement = document.getElementById(targetSection);
                        if (targetElement) {
                            targetElement.classList.remove('hidden');
                        }
                    });
                });
            });
        </script>

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