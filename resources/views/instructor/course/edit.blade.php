@extends('layouts.instructor')

@push('scripts')
    <x-head.tinymce-config />
@endpush
@section('content')
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Edit Course</h1>
            </div>
            <div class="flex space-x-3">
                <!-- Back button -->
                <a href="{{ route('instructor.courses.show', $courseData['id']) }}"
                    class="inline-flex items-center px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-gray-400 focus:ring-opacity-75 transition-colors">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Course
                </a>

                <!-- Delete button -->
                <form action="{{ route('instructor.courses.destroy', $courseData['id']) }}" method="post">
                    @method('DELETE')
                    @csrf
                    <button type="submit" onclick="return confirm('Are you sure you want to delete this course?')"
                        class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-75 transition-colors">
                        <i class="fas fa-trash-alt mr-2"></i>
                        Delete Course
                    </button>
                </form>
            </div>

        </div>

        <!-- Edit Form -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <form method="POST" action="{{ route('instructor.courses.update', $courseData['id']) }}" class="space-y-6">
                @method('PUT')
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    {{-- Title --}}
                    <div class="mb-5">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $courseData['title']) }}"
                            class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Course Code --}}
                    <div class="mb-5">
                        <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Course Code</label>
                        <input type="text" name="code" id="code" value="{{ old('code', $courseData['code']) }}"
                            class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                        @error('code')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Difficulty --}}
                    <div class="mb-5">
                        <label for="difficulty" class="block text-sm font-medium text-gray-700 mb-1">Difficulty</label>
                        <select name="difficulty" id="difficulty"
                            class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Select difficulty</option>
                            <option value="beginner" {{ old('difficulty', $courseData['difficulty']) == 'beginner' ? 'selected' : '' }}>Beginner</option>
                            <option value="intermediate" {{ old('difficulty', $courseData['difficulty']) == 'intermediate' ? 'selected' : '' }}>
                                Intermediate
                            </option>
                            <option value="advanced" {{ old('difficulty', $courseData['difficulty']) == 'advanced' ? 'selected' : '' }}>Advanced</option>
                        </select>
                        @error('difficulty')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Status (Locked to Pending) --}}
                    <div class="mb-5">
                        <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" id="status"
                            class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="pending" {{ $courseData['status'] === 'pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="approved" {{ $courseData['status'] === 'approved' ? 'selected' : '' }}>Approved
                            </option>
                            <option value="draft" {{ $courseData['status'] === 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="archived" {{ $courseData['status'] === 'archived' ? 'selected' : '' }}>Archived
                            </option>
                        </select>
                    </div>

                </div>

                {{-- Description --}}
                <div>
                    <label for="editor" class="block text-sm font-medium text-gray-700 mb-1">Course Description</label>
                    <x-forms.tinymce-editor name="description" :value="$courseData['description']" />
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Actions --}}
                <div class="flex items-center space-x-3">
                    <button class="btn-primary" type="submit">
                        <i class="fas fa-save mr-2"></i> Update Course
                    </button>
                    <a href="{{ route('instructor.courses.index') }}" class="btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
@endsection