@extends('layouts.instructor')

@section('content')
    {{-- Breadcrumbs --}}
    <nav class="flex mb-6 text-sm text-gray-500">
        <a href="{{ route('instructor.dashboard') }}" class="hover:text-gray-700">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ route('instructor.courses.index') }}" class="hover:text-gray-700">Courses</a>
        <span class="mx-2">/</span>
        <a href="{{ route('instructor.courses.show', $course) }}" class="hover:text-gray-700">{{ $course->title }}</a>
        <span class="mx-2">/</span>
        <span class="font-medium text-gray-900">Assignments</span>
    </nav>

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Assignments</h1>
            <p class="text-gray-600 mt-2">{{ $course->code }} - {{ $course->title }}</p>
        </div>
        <a class="btn-primary inline-flex items-center px-6 py-3 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200" 
           href="{{ route('instructor.courses.assignments.create', $course) }}">
            <i class="fas fa-plus mr-2"></i>
            Create Assignment
        </a>
    </div>

    @if($assignments->isEmpty())
        {{-- Empty State --}}
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-12">
            <div class="text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-gradient-to-br from-blue-100 to-indigo-100 rounded-full mb-6">
                    <i class="fas fa-tasks text-blue-600 text-3xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-3">No Assignments Yet</h3>
                <p class="text-gray-600 mb-8 max-w-md mx-auto">
                    Get started by creating your first assignment. You can add quizzes, homework, projects, and more to engage your students.
                </p>
                <a href="{{ route('instructor.courses.assignments.create', $course) }}" 
                   class="inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    Create Your First Assignment
                </a>
            </div>
        </div>
    @else
        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
            <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-white/20 rounded-lg p-3">
                        <i class="fas fa-tasks text-2xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold">{{ $assignmentData['total_count'] }}</p>
                        <p class="text-blue-100 text-sm">Total</p>
                    </div>
                </div>
                <p class="text-blue-100">All Assignments</p>
            </div>

            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-2xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-white/20 rounded-lg p-3">
                        <i class="fas fa-check-circle text-2xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold">{{ $assignmentData['published'] }}</p>
                        <p class="text-green-100 text-sm">Active</p>
                    </div>
                </div>
                <p class="text-green-100">Published</p>
            </div>

            <div class="bg-gradient-to-br from-amber-500 to-amber-600 rounded-2xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-white/20 rounded-lg p-3">
                        <i class="fas fa-edit text-2xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold">{{ $assignmentData['draft'] }}</p>
                        <p class="text-amber-100 text-sm">Pending</p>
                    </div>
                </div>
                <p class="text-amber-100">Drafts</p>
            </div>

            <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl shadow-lg p-6 text-white">
                <div class="flex items-center justify-between mb-4">
                    <div class="bg-white/20 rounded-lg p-3">
                        <i class="fas fa-clipboard-check text-2xl"></i>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold">{{ $assignmentData['pending_submissions'] }}</p>
                        <p class="text-purple-100 text-sm">Waiting</p>
                    </div>
                </div>
                <p class="text-purple-100">To Grade</p>
            </div>
        </div>

        @livewire('instructor.course.assignments.assignment-table', ['course' => $course])
    @endif

    @push('scripts')
    <script>
        // Search functionality
        document.getElementById('search')?.addEventListener('input', function(e) {
            const search = e.target.value.toLowerCase();
            document.querySelectorAll('.assignment-card').forEach(card => {
                const title = card.dataset.title;
                card.style.display = title.includes(search) ? '' : 'none';
            });
        });

        // Status filter
        document.getElementById('status-filter')?.addEventListener('change', function(e) {
            const status = e.target.value.toLowerCase();
            document.querySelectorAll('.assignment-card').forEach(card => {
                if (!status) {
                    card.style.display = '';
                } else {
                    const cardStatus = card.dataset.status;
                    card.style.display = cardStatus === status ? '' : 'none';
                }
            });
        });
    </script>
    @endpush
@endsection