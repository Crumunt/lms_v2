@extends('layouts.student')

@section('content')

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Course Catalog</h1>
            <p class="text-gray-600">Browse available courses and enroll</p>
        </div>
        <a class="btn-secondary" href="{{ route('student.courses') }}">
            <i class="fas fa-book mr-2"></i>
            My Courses
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($availableCourses as $course)
            <x-student.cards.course-card :course="$course" />
        @empty
            <div class="col-span-3 text-center py-12">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-inbox text-4xl text-gray-400"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">No available courses</h3>
                <p class="text-gray-600">You have already enrolled in all available courses.</p>
            </div>
        @endforelse
    </div>

@endsection