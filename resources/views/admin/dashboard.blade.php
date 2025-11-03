@extends('layouts.admin')

@section('content')

    <!-- Welcome Section -->
    <div class="bg-gradient-to-r from-green-600 to-green-700 rounded-2xl p-8 text-white mb-8 shadow-xl">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold mb-2">Welcome back, {{ $user->detail?->full_name }}!</h1>
                <p class="text-green-100 text-lg">Here's what's happening with your LMS today.</p>
            </div>
            <div class="hidden md:block">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center">
                    <i class="fas fa-shield-alt text-3xl text-white"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <x-admin.cards.stat-card 
            icon="fas fa-user-graduate" 
            iconBg="bg-gradient-to-br from-blue-400 to-blue-600" 
            :value="$stats['student_count']" 
            label="Total Students"
        />
        <x-admin.cards.stat-card 
            icon="fas fa-chalkboard-teacher" 
            iconBg="bg-gradient-to-br from-purple-400 to-purple-600" 
            :value="$stats['instructor_count']" 
            label="Total Instructors" 
        />
        <x-admin.cards.stat-card 
            icon="fas fa-book" 
            iconBg="bg-gradient-to-br from-orange-400 to-orange-600" 
            :value="$stats['total_courses']" 
            label="Active Courses" 
        />
        <x-admin.cards.stat-card 
            icon="fas fa-file-alt" 
            iconBg="bg-gradient-to-br from-red-400 to-red-600" 
            :value="$stats['total_materials']" 
            label="Course Materials" 
        />
    </div>

    <!-- Charts and Tables Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Enrollment Trend Chart -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Weekly Enrollment Trend</h3>
            <div class="h-64">
                <canvas id="enrollmentChart"></canvas>
            </div>
        </div>

        <!-- Content Distribution -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Content Distribution</h3>
            <div class="grid grid-cols-2 gap-4">
                <div class="text-center p-4 bg-blue-50 rounded-lg">
                    <div class="text-2xl font-bold text-blue-600">0</div>
                    <div class="text-sm text-gray-600">Video Lessons</div>
                </div>
                <div class="text-center p-4 bg-green-50 rounded-lg">
                    <div class="text-2xl font-bold text-green-600">{{ $stats['total_materials'] }}</div>
                    <div class="text-sm text-gray-600">Text Lessons</div>
                </div>
                <div class="text-center p-4 bg-purple-50 rounded-lg">
                    <div class="text-2xl font-bold text-purple-600">{{ $stats['total_courses'] }}</div>
                    <div class="text-sm text-gray-600">Total Modules</div>
                </div>
                <div class="text-center p-4 bg-yellow-50 rounded-lg">
                    <div class="text-2xl font-bold text-yellow-600">{{ $stats['assignment_count'] }}</div>
                    <div class="text-sm text-gray-600">Total Assignments</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Data Tables Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Recent Enrollments -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800">Recent Enrollments</h3>
                <a href="{{ route('admin.students') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Student</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instructor</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enrolled</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentEnrollments as $enrollment)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800">{{ $enrollment->user?->detail?->full_name }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">{{ $enrollment->course?->title }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">{{ $enrollment->course?->instructor?->detail?->full_name }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">{{ $enrollment->enrolled_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-gray-500 text-sm">No recent enrollments.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top Performing Courses -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-xl font-bold text-gray-800">Top Performing Courses</h3>
                <a href="{{ route('admin.courses') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View All</a>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Instructor</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Enrollments</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($topPerformingCourses as $course)
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800">{{ $course->title }}</td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">{{ $course->instructor?->detail?->full_name }}</td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="badge badge-info">{{ $course->enrollment_count }}</span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    <span class="badge {{ $course->status === 'approved' ? 'badge-success' : 'badge-warning' }}">
                                        {{ ucfirst($course->status) }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-4 py-6 text-center text-gray-500 text-sm">No courses available.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chart Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('enrollmentChart').getContext('2d');
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($enrollmentData['labels']),
                    datasets: [{
                        label: 'New Enrollments',
                        data: @json($enrollmentData['data']),
                        borderColor: '#3B82F6',
                        backgroundColor: 'rgba(59, 130, 246, 0.1)',
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        },
                        x: {
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            }
                        }
                    }
                }
            });
        });
    </script>

    
@endsection