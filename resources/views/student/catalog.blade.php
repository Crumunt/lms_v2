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

    @livewire('student.student-course-catalog')

@endsection