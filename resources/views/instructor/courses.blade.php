@extends('layouts.instructor')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">My Courses</h1>
            <p class="text-gray-600 mt-2">Manage and organize your course materials</p>
        </div>

        @can('create', $allCourses)
            <button class="btn-primary" onclick="window.location.href='{{ route('instructor.courses.create') }}'">
                <i class="fas fa-plus mr-2"></i>
                Create New Course
            </button>
        @endcan
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($allCourses as $course)
            <x-instructor.cards.course-card :course="$course" />
        @empty
            <div class="col-span-full text-center py-10">
                <p class="text-gray-500 text-lg font-medium">No courses created yet.</p>
                @cannot('create', $allCourses)
                <p class="text-gray-600 font-medium mt-3">Wait for the admin to approve of your account before you can create courses.</p>
                @endcannot
            </div>
        @endforelse
    </div>

@endsection