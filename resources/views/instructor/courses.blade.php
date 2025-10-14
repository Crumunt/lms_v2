@extends('layouts.instructor')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">My Courses</h1>
            <p class="text-gray-600 mt-2">Manage and organize your course materials</p>
        </div>
        <button class="btn-primary" onclick="window.location.href='{{ route('instructor.course.create') }}'">
            <i class="fas fa-plus mr-2"></i>
            Create New Course
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($allCourses as $course)
            <x-instructor.cards.course-card :course="$course" />
        @endforeach
    </div>
@endsection