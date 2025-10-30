@props(['user' => ['name' => 'Dr. Lorenz', 'department' => 'Computer Science', 'initials' => 'JS']])

@extends('layouts.instructor')
@push('scripts')
    <x-head.tinymce-config />
@endpush
@section('content')

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Create Course</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
        <form method="POST" action="{{ route('instructor.courses.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Title --}}
                <div class="mb-5">
                    <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}"
                        class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                    @error('title')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Course Code --}}
                <div class="mb-5">
                    <label for="code" class="block text-sm font-medium text-gray-700 mb-1">Course Code</label>
                    <input type="text" name="code" id="code" value="{{ old('code') }}"
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
                        <option value="beginner" {{ old('difficulty') == 'beginner' ? 'selected' : '' }}>Beginner</option>
                        <option value="intermediate" {{ old('difficulty') == 'intermediate' ? 'selected' : '' }}>Intermediate
                        </option>
                        <option value="advanced" {{ old('difficulty') == 'advanced' ? 'selected' : '' }}>Advanced</option>
                    </select>
                    @error('difficulty')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Status (Locked to Pending) --}}
                <div class="mb-5">
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" id="status"
                        class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
                        readonly>
                        <option value="pending" selected>Pending</option>
                    </select>
                    <p class="text-xs text-gray-500 mt-1 italic">
                        All newly created courses require admin approval before they become active.
                    </p>
                </div>

            </div>

            {{-- Description --}}
            <div>
                <label for="editor" class="block text-sm font-medium text-gray-700 mb-1">Course Description</label>
                <x-forms.tinymce-editor name="description" />
                @error('plain_description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Actions --}}
            <div class="flex items-center space-x-3">
                <button class="btn-primary" type="submit">
                    <i class="fas fa-save mr-2"></i> Save Course
                </button>
                <a href="{{ route('instructor.courses.index') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>

@endsection