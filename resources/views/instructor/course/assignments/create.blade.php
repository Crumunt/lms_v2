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
        <span class="font-medium text-gray-900">Create</span>
    </nav>

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Create Assignment</h1>
            <p class="text-gray-600 mt-2">Create a new assignment for {{ $course->code }} - {{ $course->title }}</p>
        </div>
        <a href="{{ route('instructor.courses.assignments.index', $course) }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Assignments
        </a>
    </div>

    <form action="{{ route('instructor.courses.assignments.store', $course) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Basic Information Card --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                        Basic Information
                    </h2>

                    {{-- Title --}}
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Assignment Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               value="{{ old('title') }}"
                               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 @error('title') border-red-500 @enderror" 
                               placeholder="e.g., Week 1 Quiz - Introduction to Programming"
                               required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Choose a clear, descriptive title for your assignment</p>
                    </div>

                    {{-- Description --}}
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description
                        </label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4" 
                                  class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 @error('description') border-red-500 @enderror"
                                  placeholder="Provide a brief overview of the assignment...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Preview Section (Optional) --}}
                    <div>
                        <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                            <div class="flex items-start">
                                <i class="fas fa-lightbulb text-blue-600 text-xl mr-3 mt-1"></i>
                                <div>
                                    <h3 class="font-semibold text-blue-900 mb-1">Pro Tips</h3>
                                    <ul class="text-sm text-blue-800 space-y-1">
                                        <li>• Use clear, specific titles that describe the assignment's purpose</li>
                                        <li>• Include step-by-step instructions to guide students</li>
                                        <li>• Set realistic due dates considering your students' schedules</li>
                                        <li>• Save as draft to review before publishing</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Submission Settings Card --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-upload text-purple-600 mr-2"></i>
                        Submission Settings
                    </h2>

                    {{-- Submission Type --}}
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Submission Type <span class="text-red-500">*</span>
                        </label>
                        <div class="space-y-3">
                            <label class="flex items-start p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition @error('submission_type') border-red-500 @enderror">
                                <input type="radio" 
                                       name="submission_type" 
                                       value="file" 
                                       {{ old('submission_type', 'file') === 'file' ? 'checked' : '' }}
                                       class="mt-1">
                                <div class="ml-3">
                                    <div class="font-medium text-gray-900">File Upload</div>
                                    <div class="text-sm text-gray-500">Students upload documents, PDFs, images, etc.</div>
                                </div>
                            </label>

                            <label class="flex items-start p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition opacity-50 hover:pointer-events-none">
                                <input type="radio" 
                                       name="submission_type" 
                                       value="text" 
                                       {{ old('submission_type') === 'text' ? 'checked' : '' }}
                                       class="mt-1"
                                       disabled />
                                <div class="ml-3">
                                    <div class="font-medium text-gray-900">Text Submission</div>
                                    <div class="text-sm text-gray-500">Students type their answer directly</div>
                                </div>
                            </label>

                            <label class="flex items-start p-4 border rounded-lg cursor-pointer hover:bg-gray-50 transition opacity-50 hover:pointer-events-none">
                                <input type="radio" 
                                       name="submission_type" 
                                       value="both" 
                                       {{ old('submission_type') === 'both' ? 'checked' : '' }}
                                       class="mt-1"
                                       disabled />
                                <div class="ml-3">
                                    <div class="font-medium text-gray-900">Both</div>
                                    <div class="text-sm text-gray-500">Students can upload files and/or type text</div>
                                </div>
                            </label>
                        </div>
                        @error('submission_type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Allow Late Submission --}}
                    <div>
                        <label class="flex items-center cursor-pointer">
                            <input type="checkbox" 
                                   name="allow_late_submission" 
                                   id="allow_late_submission"
                                   value="1"
                                   {{ old('allow_late_submission') ? 'checked' : '' }}
                                   class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500">
                            <span class="ml-3">
                                <span class="font-medium text-gray-900">Allow late submissions</span>
                                <span class="block text-sm text-gray-500">Students can submit after the due date</span>
                            </span>
                        </label>
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

                    <div>
                        <label for="total_points" class="block text-sm font-medium text-gray-700 mb-2">
                            Total Points <span class="text-red-500">*</span>
                        </label>
                        <input type="number" 
                               name="total_points" 
                               id="total_points" 
                               value="{{ old('total_points', 100) }}"
                               min="1"
                               max="1000"
                               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 @error('total_points') border-red-500 @enderror"
                               required>
                        @error('total_points')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Maximum points students can earn</p>
                    </div>
                </div>

                {{-- Due Date Card --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-calendar text-green-600 mr-2"></i>
                        Schedule
                    </h2>

                    {{-- Due Date --}}
                    <div>
                        <label for="due_date" class="block text-sm font-medium text-gray-700 mb-2">
                            Due Date
                        </label>
                        <input type="datetime-local" 
                               name="due_date" 
                               id="due_date" 
                               value="{{ old('due_date', now()->addWeek()->format('Y-m-d\TH:i')) }}"
                               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 @error('due_date') border-red-500 @enderror">
                        @error('due_date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Deadline for submissions</p>
                    </div>
                </div>

                {{-- Status Card --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-toggle-on text-indigo-600 mr-2"></i>
                        Status
                    </h2>

                    <div class="space-y-3">
                        <label class="flex items-start p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition">
                            <input type="radio" 
                                   name="status" 
                                   value="draft" 
                                   {{ old('status', 'draft') === 'draft' ? 'checked' : '' }}
                                   class="mt-1">
                            <div class="ml-3">
                                <div class="font-medium text-gray-900">Draft</div>
                                <div class="text-xs text-gray-500">Only visible to you</div>
                            </div>
                        </label>

                        <label class="flex items-start p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition">
                            <input type="radio" 
                                   name="status" 
                                   value="published" 
                                   {{ old('status') === 'published' ? 'checked' : '' }}
                                   class="mt-1">
                            <div class="ml-3">
                                <div class="font-medium text-gray-900">Published</div>
                                <div class="text-xs text-gray-500">Students can view and submit</div>
                            </div>
                        </label>

                        <label class="flex items-start p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition">
                            <input type="radio" 
                                   name="status" 
                                   value="closed" 
                                   {{ old('status') === 'closed' ? 'checked' : '' }}
                                   class="mt-1">
                            <div class="ml-3">
                                <div class="font-medium text-gray-900">Closed</div>
                                <div class="text-xs text-gray-500">No new submissions allowed</div>
                            </div>
                        </label>
                    </div>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Action Buttons --}}
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl shadow-lg border border-blue-100 p-6">
                    <button type="submit" 
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center mb-3">
                        <i class="fas fa-check mr-2"></i>
                        Create Assignment
                    </button>
                    <a href="{{ route('instructor.courses.assignments.index', $course) }}" 
                       class="w-full bg-white hover:bg-gray-50 text-gray-700 font-semibold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center border border-gray-300">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </form>

    

    @push('scripts')
    <script>
        // Set minimum date to today for date inputs
        const today = new Date().toISOString().slice(0, 16);
        document.getElementById('available_from').min = today;
        document.getElementById('due_date').min = today;

        // Validate due date is after available from
        document.getElementById('due_date').addEventListener('change', function() {
            const availableFrom = new Date(document.getElementById('available_from').value);
            const dueDate = new Date(this.value);
            
            if (dueDate <= availableFrom) {
                alert('Due date must be after the available from date');
                this.value = '';
            }
        });
    </script>
    @endpush
@endsection