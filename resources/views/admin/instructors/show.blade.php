@extends('layouts.admin')

@section('content')
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Instructor Details</h1>
                <p class="text-gray-600 mt-2">View and manage instructor information</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.instructors.edit', $instructor) }}" class="btn-secondary">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Instructor
                </a>
                <a href="{{ route('admin.instructors') }}" class="btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Instructors
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Instructor Information -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="text-center">
                    <div
                        class="w-24 h-24 bg-gradient-to-r from-blue-600 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-white text-2xl font-bold">{{ substr($instructor->name, 0, 2) }}</span>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-2">{{ $instructor->name }}</h3>
                    <p class="text-gray-600 mb-4">{{ $instructor->email }}</p>
                    <span
                        class="badge {{ $instructor->status === 'approved' ? 'badge-success' : ($instructor->status === 'pending' ? 'badge-warning' : 'badge-danger') }}">
                        {{ ucfirst($instructor->status) }}
                    </span>
                </div>

                <div class="mt-6 space-y-4">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Address</h4>
                        <p class="text-gray-800 mt-1">{{ $instructor->address }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Joined</h4>
                        <p class="text-gray-800 mt-1">{{ $instructor->created_at->format('M d, Y') }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 uppercase tracking-wider">Last Updated</h4>
                        <p class="text-gray-800 mt-1">{{ $instructor->updated_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Taught Courses -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-xl font-bold text-gray-800">Taught Courses</h3>
                    <span class="badge badge-info">{{ $instructor->taughtCourses->count() }} courses</span>
                </div>

                @if($instructor->taughtCourses->count() > 0)
                    <div class="space-y-4">
                        @foreach($instructor->taughtCourses as $course)
                            <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <h4 class="text-lg font-semibold text-gray-800">{{ $course->title }}</h4>
                                        <p class="text-gray-600 text-sm">{{ $course->code }}</p>
                                        <p class="text-gray-500 text-sm mt-1">{{ $course->description }}</p>
                                        <div class="flex items-center mt-2 space-x-4">
                                            <span class="text-sm text-gray-500">
                                                <i class="fas fa-users mr-1"></i>
                                                {{ $course->enrollment_count }} students
                                            </span>
                                            <span class="text-sm text-gray-500">
                                                <i class="fas fa-calendar mr-1"></i>
                                                Created {{ $course->created_at->format('M d, Y') }}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <span
                                            class="badge {{ $course->status === 'approved' ? 'badge-success' : ($course->status === 'pending' ? 'badge-warning' : 'badge-danger') }}">
                                            {{ ucfirst($course->status) }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-book text-4xl text-gray-300 mb-4"></i>
                        <h4 class="text-lg font-medium text-gray-500 mb-2">No Courses Taught</h4>
                        <p class="text-gray-400">This instructor hasn't created any courses yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection