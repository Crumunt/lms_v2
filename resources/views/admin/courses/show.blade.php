@extends('layouts.admin')

@section('content')
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $course->title }}</h1>
                <p class="text-gray-600 mt-2">{{ $course->code }} • {{ $course->enrollments->count() }} students</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.courses.edit', $course) }}" class="btn-secondary">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Course
                </a>
                <a href="{{ route('admin.courses') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Courses
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Course Information -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="text-center">
                    <div
                        class="w-24 h-24 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <i class="fas fa-book text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $course->title }}</h3>
                    <p class="text-gray-600 mb-4">{{ $course->code }}</p>
                    <span
                        class="badge {{ $course->status === 'approved' ? 'badge-success' : ($course->status === 'pending' ? 'badge-warning' : 'badge-danger') }}">
                        {{ ucfirst($course->status) }}
                    </span>
                </div>

                <div class="mt-6 space-y-4">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Instructor</h4>
                        <p class="text-gray-800 mt-1">{{ $course->instructor->name }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Difficulty</h4>
                        <p class="text-gray-800 mt-1">{{ ucfirst($course->difficulty) }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Enrollments</h4>
                        <p class="text-gray-800 mt-1">{{ $course->enrollments->count() }} students</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Created</h4>
                        <p class="text-gray-800 mt-1">{{ $course->created_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course Details and Content -->
        <div class="lg:col-span-2 space-y-8">
            <!-- Course Description -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-xl font-bold text-gray-800 mb-4">Course Description</h3>
                <p class="text-gray-600">{{ $course->description }}</p>
            </div>

            <!-- Course Content -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Course Content</h3>
                    <span class="badge badge-info">{{ $course->contents->count() }} materials</span>
                </div>

                @if($course->contents->count() > 0)
                    <div class="space-y-4">
                        @foreach($course->contents as $content)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-file-pdf text-red-600"></i>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-semibold text-gray-800">{{ $content->title }}</h4>
                                            <p class="text-xs text-gray-500">{{ $content->description }}</p>
                                            <p class="text-xs text-gray-400">Uploaded: {{ $content->uploaded_at->format('M d, Y') }}
                                            </p>
                                        </div>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <span
                                            class="badge {{ $content->status === 'published' ? 'badge-success' : ($content->status === 'draft' ? 'badge-warning' : 'badge-danger') }}">
                                            {{ ucfirst($content->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-file-alt text-4xl text-gray-300 mb-4"></i>
                        <h4 class="text-lg font-medium text-gray-500 mb-2">No Content Available</h4>
                        <p class="text-gray-400">This course doesn't have any content uploaded yet.</p>
                    </div>
                @endif
            </div>

            <!-- Enrolled Students -->
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Enrolled Students</h3>
                    <span class="badge badge-info">{{ $course->enrollments->count() }} students</span>
                </div>

                @if($course->enrollments->count() > 0)
                    <div class="space-y-3">
                        @foreach($course->enrollments as $enrollment)
                            <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div
                                        class="w-8 h-8 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center">
                                        <span
                                            class="text-white text-xs font-medium">{{ substr($enrollment->student->name, 0, 2) }}</span>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-800">{{ $enrollment->student->name }}</p>
                                        <p class="text-xs text-gray-500">{{ $enrollment->student->email }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="badge {{ $enrollment->status === 'active' ? 'badge-success' : 'badge-warning' }}">
                                        {{ ucfirst($enrollment->status) }}
                                    </span>
                                    <p class="text-xs text-gray-500 mt-1">{{ $enrollment->enrolled_at->format('M d, Y') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-users text-4xl text-gray-300 mb-4"></i>
                        <h4 class="text-lg font-medium text-gray-500 mb-2">No Students Enrolled</h4>
                        <p class="text-gray-400">No students have enrolled in this course yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection