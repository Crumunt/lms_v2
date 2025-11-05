@extends('layouts.admin')

@section('content')
    <!-- Page Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Instructor Management</h1>
                <p class="text-gray-600 mt-2">Manage all instructors in the system</p>
            </div>
        </div>
    </div>

    <!-- Instructors Info -->
    @livewire('admin.instructor.instructor-list')
@endsection