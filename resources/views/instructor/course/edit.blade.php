@extends('layouts.instructor')
@section('content')
    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">Edit Course</h1>
                <p class="text-gray-600 mt-2">{{ $courseData['code'] }} • {{ $courseData['enrollment_count'] }} students</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('instructor.course.show', $courseData['id']) }}" class="btn-secondary">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Course
                </a>
                <button class="btn-primary" onclick="document.getElementById('editForm').submit()">
                    <i class="fas fa-save mr-2"></i>
                    Save Changes
                </button>
            </div>
        </div>

        <!-- Edit Form -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
            <form id="editForm" method="POST" action="{{ route('instructor.course.update', $courseData['id']) }}">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Course Title</label>
                        <input type="text" name="title" value="{{ $courseData['title'] }}"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Course Code</label>
                        <input type="text" name="code" value="{{ $courseData['code'] }}"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            required>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                    <textarea name="description" rows="4"
                        class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                        required>{{ $courseData['description'] }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Difficulty</label>
                        <select name="difficulty"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="beginner" {{ $courseData['difficulty'] == 'beginner' ? 'selected' : '' }}>Beginner
                            </option>
                            <option value="intermediate" {{ $courseData['difficulty'] == 'intermediate' ? 'selected' : '' }}>
                                Intermediate</option>
                            <option value="advanced" {{ $courseData['difficulty'] == 'advanced' ? 'selected' : '' }}>Advanced
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                        <select name="status"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                            <option value="draft" {{ $courseData['status'] == 'draft' ? 'selected' : '' }}>Draft</option>
                            <option value="approved" {{ $courseData['status'] == 'approved' ? 'selected' : '' }}>Approved
                            </option>
                            <option value="archived" {{ $courseData['status'] == 'archived' ? 'selected' : '' }}>Archived
                            </option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Enrollment Count</label>
                        <input type="number" name="enrollment_count" value="{{ $courseData['enrollment_count'] }}"
                            class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                            readonly>
                        <p class="text-xs text-gray-500 mt-1">This field is automatically managed</p>
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('instructor.course.show', $courseData['id']) }}" class="btn-secondary">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </a>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-save mr-2"></i>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection