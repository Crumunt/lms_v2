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
        <a href="{{ route('instructor.courses.assignments.index', $course) }}" class="hover:text-gray-700">Assignments</a>
        <span class="mx-2">/</span>
        <span class="font-medium text-gray-900">{{ $assignment->title }}</span>
    </nav>

    <div class="flex items-center justify-between mb-8">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <h1 class="text-3xl font-bold text-gray-800">{{ $assignment->title }}</h1>
                @if($assignment->status === 'draft')
                    <span class="px-3 py-1 bg-gray-100 text-gray-700 text-sm font-medium rounded-full">Draft</span>
                @elseif($assignment->status === 'published')
                    <span class="px-3 py-1 bg-green-100 text-green-700 text-sm font-medium rounded-full">Published</span>
                @else
                    <span class="px-3 py-1 bg-red-100 text-red-700 text-sm font-medium rounded-full">Closed</span>
                @endif
            </div>
            <p class="text-gray-600 mt-2">{{ $course->code }} - {{ $course->title }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('instructor.courses.assignments.edit', [$course, $assignment]) }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-edit mr-2"></i>
                Edit Assignment
            </a>
            <a href="{{ route('instructor.courses.assignments.index', $course) }}"
                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Assignments
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Assignment Details Card --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                    Assignment Details
                </h2>

                {{-- Description --}}
                @if($assignment->description)
                    <div class="mb-6">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Description</h3>
                        <div class="text-gray-600 bg-gray-50 rounded-lg p-4">
                            {{ $assignment->description }}
                        </div>
                    </div>
                @endif

                {{-- Submission Type --}}
                <div class="mb-6">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Submission Type</h3>
                    <div class="flex items-center">
                        @if($assignment->submission_type === 'file')
                            <span class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-sm">
                                <i class="fas fa-file-upload mr-2"></i>
                                File Upload
                            </span>
                        @elseif($assignment->submission_type === 'text')
                            <span class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm">
                                <i class="fas fa-keyboard mr-2"></i>
                                Text Submission
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 bg-indigo-100 text-indigo-700 rounded-full text-sm">
                                <i class="fas fa-file-alt mr-2"></i>
                                Both
                            </span>
                        @endif
                    </div>
                </div>

                {{-- Late Submission --}}
                <div>
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Late Submissions</h3>
                    <div class="flex items-center">
                        @if($assignment->allow_late_submission)
                            <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm">
                                <i class="fas fa-check-circle mr-2"></i>
                                Allowed
                            </span>
                        @else
                            <span class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-full text-sm">
                                <i class="fas fa-times-circle mr-2"></i>
                                Not Allowed
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Statistics Card --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-chart-bar text-indigo-600 mr-2"></i>
                    Submission Statistics
                </h2>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-blue-50 rounded-lg p-4">
                        <div class="text-3xl font-bold text-blue-600">{{ $submissionStats->submitted }}</div>
                        <div class="text-sm text-gray-600 mt-1">Submitted</div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-4">
                        <div class="text-3xl font-bold text-green-600">{{ $submissionStats->graded }}</div>
                        <div class="text-sm text-gray-600 mt-1">Graded</div>
                    </div>
                    <div class="bg-yellow-50 rounded-lg p-4">
                        <div class="text-3xl font-bold text-yellow-600">{{ $submissionStats->late }}</div>
                        <div class="text-sm text-gray-600 mt-1">Late</div>
                    </div>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="text-3xl font-bold text-gray-600">{{ $submissionStats->pending }}</div>
                        <div class="text-sm text-gray-600 mt-1">Pending</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- Grading Card --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-star text-amber-600 mr-2"></i>
                    Grading
                </h2>

                <div class="text-center">
                    <div class="text-4xl font-bold text-amber-600 mb-2">{{ $assignment->total_points }}</div>
                    <div class="text-sm text-gray-600">Total Points</div>
                </div>

                @if(true)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm text-gray-600">Average Score</span>
                            <span class="text-lg font-bold text-gray-800">
                                {{ number_format(11, 1) }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="text-sm text-gray-600">Highest Score</span>
                            <span class="text-lg font-bold text-green-600">
                                {{ 100 }}
                            </span>
                        </div>
                    </div>
                @endif
            </div>

            {{-- Schedule Card --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                    <i class="fas fa-calendar text-green-600 mr-2"></i>
                    Schedule
                </h2>

                <div class="space-y-4">
                    @if($assignment->available_from)
                        <div>
                            <div class="text-sm text-gray-600 mb-1">Available From</div>
                            <div class="font-medium text-gray-800">
                                {{ \Carbon\Carbon::parse($assignment->available_from)->format('M d, Y') }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($assignment->available_from)->format('h:i A') }}
                            </div>
                        </div>
                    @endif

                    @if($assignment->due_date)
                        <div class="pt-4 border-t border-gray-200">
                            <div class="text-sm text-gray-600 mb-1">Due Date</div>
                            <div class="font-medium text-gray-800">
                                {{ \Carbon\Carbon::parse($assignment->due_date)->format('M d, Y') }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ \Carbon\Carbon::parse($assignment->due_date)->format('h:i A') }}
                            </div>
                            @if(\Carbon\Carbon::parse($assignment->due_date)->isPast())
                                <span class="inline-block mt-2 px-2 py-1 bg-red-100 text-red-700 text-xs rounded-full">
                                    Overdue
                                </span>
                            @else
                                <span class="inline-block mt-2 px-2 py-1 bg-green-100 text-green-700 text-xs rounded-full">
                                    {{ \Carbon\Carbon::parse($assignment->due_date)->diffForHumans() }}
                                </span>
                            @endif
                        </div>
                    @endif
                </div>
            </div>

            {{-- Quick Actions Card --}}
            <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl shadow-lg border border-blue-100 p-6">
                <h3 class="font-semibold text-gray-800 mb-4">Quick Actions</h3>
                <div class="space-y-2">
                    <a href="{{ route('instructor.courses.assignments.edit', [$course, $assignment]) }}"
                        class="w-full bg-white hover:bg-gray-50 text-gray-700 font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center border border-gray-300">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Assignment
                    </a>
                    <form action="{{ route('instructor.courses.assignments.destroy', [$course, $assignment]) }}"
                        method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this assignment? This action cannot be undone.');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                            class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition duration-200 flex items-center justify-center">
                            <i class="fas fa-trash mr-2"></i>
                            Delete Assignment
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- Submissions Table --}}
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-file-alt text-blue-600 mr-2"></i>
                Student Submissions
            </h2>
            <div class="flex gap-2">
                <button class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 text-sm">
                    <i class="fas fa-filter mr-2"></i>
                    Filter
                </button>
                <button class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 text-sm">
                    <i class="fas fa-download mr-2"></i>
                    Export
                </button>
            </div>
        </div>

        @if($submissions->isEmpty())
            <div class="text-center py-12">
                <i class="fas fa-inbox text-gray-300 text-5xl mb-4"></i>
                <h3 class="text-lg font-medium text-gray-600 mb-2">No Submissions Yet</h3>
                <p class="text-gray-500">Students haven't submitted their work for this assignment.</p>
            </div>
        @else
            @livewire('instructor.course.assignments.submission-list', ['assignment' => $assignment])


            {{-- Pagination --}}
            @if($submissions->hasPages())
                <div class="mt-6">
                    {{ $submissions->links() }}
                </div>
            @endif
        @endif
    </div>
@endsection