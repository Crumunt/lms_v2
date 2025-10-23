@extends('layouts.student')

@section('content')
    <!-- Course Header -->
    <div class="bg-gradient-to-r from-green-600 to-green-500 text-white rounded-2xl p-8 mb-8">
        <div class="flex items-center space-x-6">
            <div class="w-20 h-20 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                <i class="{{ $courseData['icon'] }} text-4xl"></i>
            </div>
            <div class="flex-1">
                <h1 class="text-3xl font-bold mb-2">{{ $courseData['title'] }}</h1>
                <p class="text-green-100 text-lg">{{ $courseData['code'] }}</p>
                @if($courseData['enrolled'])
                    <div class="flex items-center mt-3">
                        <i class="fas fa-graduation-cap mr-2"></i>
                        <span class="text-sm">Enrolled since {{ $courseData['enrollmentDate'] }}</span>
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
                    <a href="#materials"
                        class="course-nav-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 text-gray-600 hover:bg-gray-50 hover:text-gray-800">
                        <i class="fas fa-book mr-3"></i>
                        <span>Course Materials</span>
                    </a>
                    <a href="#modules"
                        class="course-nav-item flex items-center px-4 py-3 rounded-xl transition-all duration-200 text-gray-600 hover:bg-gray-50 hover:text-gray-800">
                        <i class="fas fa-list mr-3"></i>
                        <span>Learning Modules</span>
                    </a>
                    <div class="mt-4">
                        <button class="btn-secondary w-full" onclick="unenrollFromCourse({{ $courseData['id'] }})">
                            <i class="fas fa-sign-out-alt mr-2"></i>
                            Unenroll
                        </button>
                    </div>
                </div>

                <!-- Enrollment Status -->
                <div class="mt-6 p-4 bg-blue-50 rounded-xl border border-blue-200">
                    <div class="text-center">
                        <i class="fas fa-graduation-cap text-blue-600 text-2xl mb-2"></i>
                        <p class="text-sm font-medium text-blue-800">Enrolled</p>
                        <p class="text-xs text-blue-600">Since {{ $courseData['enrollmentDate'] }}</p>
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
                            {{ $courseData['description'] }}
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
                                            <p class="font-medium text-gray-800">{{ $courseData['instructor']['name'] }}</p>
                                            <p class="text-xs text-gray-500">{{ $courseData['instructor']['email'] }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Materials Section -->
            <div id="materials" class="course-section hidden">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Course Materials</h3>

                    <!-- Textbooks -->
                    <div class="mb-8">
                        <h4 class="font-semibold text-gray-700 mb-4">Required Textbooks</h4>
                        <div class="space-y-4">
                            <div class="bg-gray-50 border border-gray-200 rounded-xl p-6 hover:shadow-md transition">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1">
                                        <h5 class="font-medium text-gray-800">Introduction to Programming with Python</h5>
                                        <p class="text-sm text-gray-600">Author: John Zelle</p>
                                        <p class="text-xs text-gray-500">Publisher: Franklin, Beedle & Associates</p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <button class="text-blue-600 hover:text-blue-800 text-sm">
                                            <i class="fas fa-download mr-1"></i>Download
                                        </button>
                                        <button class="text-green-600 hover:text-green-800 text-sm">
                                            <i class="fas fa-external-link-alt mr-1"></i>View
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Lecture Slides -->
                    <div class="mb-8">
                        <h4 class="font-semibold text-gray-700 mb-4">Lecture Slides</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 hover:shadow-md transition">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-file-powerpoint text-blue-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h5 class="font-medium text-gray-800">Week 1: Introduction</h5>
                                        <p class="text-xs text-gray-500">Updated 2 days ago</p>
                                    </div>
                                    <button class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 hover:shadow-md transition">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-file-powerpoint text-blue-600"></i>
                                    </div>
                                    <div class="flex-1">
                                        <h5 class="font-medium text-gray-800">Week 2: Variables & Data Types</h5>
                                        <p class="text-xs text-gray-500">Updated 1 week ago</p>
                                    </div>
                                    <button class="text-blue-600 hover:text-blue-800">
                                        <i class="fas fa-download"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Learning Modules Section -->
            <div id="modules" class="course-section hidden">
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                    <h3 class="text-2xl font-bold text-gray-800 mb-6">Learning Modules</h3>

                    <div class="space-y-6">
                        <!-- Module 1 -->
                        <div class="bg-gray-50 border border-gray-200 rounded-xl overflow-hidden">
                            <div class="bg-white px-6 py-4 border-b border-gray-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                            1</div>
                                        <div>
                                            <h4 class="font-semibold text-gray-800">Introduction to Programming</h4>
                                            <p class="text-sm text-gray-600">Week 1-2</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm text-green-600 font-medium">Completed</span>
                                        <i class="fas fa-check-circle text-green-500"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="space-y-3">
                                    <div class="flex items-center space-x-3 p-3 bg-green-50 rounded-lg">
                                        <i class="fas fa-play-circle text-green-600"></i>
                                        <span class="text-sm font-medium text-gray-800">What is Programming?</span>
                                        <span class="ml-auto text-xs text-gray-500">15 min</span>
                                    </div>
                                    <div class="flex items-center space-x-3 p-3 bg-green-50 rounded-lg">
                                        <i class="fas fa-play-circle text-green-600"></i>
                                        <span class="text-sm font-medium text-gray-800">Programming Languages
                                            Overview</span>
                                        <span class="ml-auto text-xs text-gray-500">20 min</span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Module 2 -->
                        <div class="bg-gray-50 border border-gray-200 rounded-xl overflow-hidden">
                            <div class="bg-white px-6 py-4 border-b border-gray-200">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div
                                            class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center text-white text-sm font-bold">
                                            2</div>
                                        <div>
                                            <h4 class="font-semibold text-gray-800">Control Structures</h4>
                                            <p class="text-sm text-gray-600">Week 5-6</p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span class="text-sm text-blue-600 font-medium">In Progress</span>
                                        <i class="fas fa-clock text-blue-500"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="p-6">
                                <div class="space-y-3">
                                    <div class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg">
                                        <i class="fas fa-play-circle text-blue-600"></i>
                                        <span class="text-sm font-medium text-gray-800">If-Else Statements</span>
                                        <span class="ml-auto text-xs text-gray-500">22 min</span>
                                    </div>
                                    <div class="flex items-center space-x-3 p-3 bg-gray-50 rounded-lg">
                                        <i class="fas fa-lock text-gray-400"></i>
                                        <span class="text-sm font-medium text-gray-500">Loops and Iteration</span>
                                        <span class="ml-auto text-xs text-gray-400">28 min</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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