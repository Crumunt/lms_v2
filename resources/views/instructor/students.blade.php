@extends('layouts.instructor')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Students</h1>
            <p class="text-gray-600 mt-2">Manage your students across all courses</p>
        </div>
    </div>

    @livewire('instructor.students.enrolled-students-table')
@endsection