@extends('layouts.admin')

@section('content')
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Instructor Management</h1>
                <p class="text-gray-600 mt-2">Manage all instructors in the system</p>
            </div>
            <a href="{{ route('admin.instructors.create') }}" class="btn-primary">
                <i class="fas fa-plus mr-2"></i>
                Add New Instructor
            </a>
        </div>
    </div>

    <!-- Instructors Info -->
    @livewire('admin.instructor.instructor-list')
@endsection