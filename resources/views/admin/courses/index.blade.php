@extends('layouts.admin')

@section('content')
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Course Management</h1>
                <p class="text-gray-600 mt-2">Manage all courses in the system</p>
            </div>
        </div>
    </div>

    <!-- Courses Info -->
    @livewire('admin.course.course-list')
@endsection