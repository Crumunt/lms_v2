@extends('layouts.instructor')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Assignments</h1>
            <p class="text-gray-600 mt-2">Create and manage course assignments</p>
        </div>
        <button class="btn-primary" onclick="window.location.href='{{ route('instructor.assignment.create') }}'">
            <i class="fas fa-plus mr-2"></i>
            Create Assignment
        </button>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
        <div class="text-center py-12">
            <i class="fas fa-tasks text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-medium text-gray-600 mb-2">Assignment Management</h3>
            <p class="text-gray-500">This page will show all your assignments and submissions</p>
        </div>
    </div>

@endsection