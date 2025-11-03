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
        <span class="font-medium text-gray-900">Update Content</span>
    </nav>

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Update Course Content</h1>
            <p class="text-gray-600 mt-2">Add new materials for {{ $course->code }} - {{ $course->title }}</p>
        </div>
        <a href="{{ route('instructor.courses.show', $course) }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
            <i class="fas fa-arrow-left mr-2"></i>
            Back to Course
        </a>
    </div>

    <form action="{{ route('instructor.courses.content.update', [$course, $content]) }}" method="POST" enctype="multipart/form-data" id="content-upload-form">
        @method('PUT')
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Basic Information Card --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                        Content Information
                    </h2>

                    {{-- Title --}}
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                            Content Title <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               name="title" 
                               id="title" 
                               value="{{ old('title', $content->title) }}"
                               class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 @error('title') border-red-500 @enderror" 
                               placeholder="e.g., Week 1 - Introduction to Programming"
                               required>
                        @error('title')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Choose a clear, descriptive title for your content</p>
                    </div>

                    {{-- Description --}}
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Description <span class="text-red-500">*</span>
                        </label>
                        <textarea name="description" 
                                  id="description" 
                                  rows="4" 
                                  class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 @error('description') border-red-500 @enderror"
                                  placeholder="Provide a brief overview of the content..."
                                  required>{{ old('description', $content->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Describe what students will learn from this material</p>
                    </div>

                    {{-- Pro Tips --}}
                    <div class="mt-6 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-lg">
                        <div class="flex items-start">
                            <i class="fas fa-lightbulb text-blue-600 text-xl mr-3 mt-1"></i>
                            <div>
                                <h3 class="font-semibold text-blue-900 mb-1">Pro Tips</h3>
                                <ul class="text-sm text-blue-800 space-y-1">
                                    <li>• Use clear, descriptive titles that indicate the content's topic</li>
                                    <li>• Ensure PDFs are properly formatted and readable</li>
                                    <li>• Maximum file size is 10MB</li>
                                    <li>• Save as draft to review before publishing to students</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- File Upload Card --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-file-pdf text-red-600 mr-2"></i>
                        PDF File Upload
                    </h2>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-3">
                            Upload PDF <span class="text-red-500">*</span>
                        </label>
                        
                        {{-- Drop Zone --}}
                        <div class="file-drop-zone" id="file-drop-zone" onclick="document.getElementById('file-input').click()">
                            <div class="file-drop-content">
                                <i class="fas fa-cloud-upload-alt text-5xl text-gray-400 mb-4"></i>
                                <h5 class="text-gray-700 font-medium text-lg mb-2">Drop PDF file here or click to browse</h5>
                                <p class="text-gray-500 text-sm mb-4">Maximum file size: 10MB</p>
                                <div class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                                    <i class="fas fa-folder-open mr-2"></i>
                                    Choose File
                                </div>
                            </div>
                        </div>
                        <input type="file" 
                               id="file-input" 
                               name="file" 
                               accept=".pdf,application/pdf" 
                               class="hidden">
                        @error('file')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror

                        {{-- File Preview --}}
                        <div id="file-preview" class="hidden mt-4">
                            <div class="bg-green-50 border-2 border-green-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center flex-1">
                                        <div class="flex-shrink-0 w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                                            <i class="fas fa-file-pdf text-2xl text-red-600"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h6 class="font-semibold text-gray-800 truncate" id="file-name">filename.pdf</h6>
                                            <p class="text-sm text-gray-600" id="file-size">File size</p>
                                            <div class="mt-2">
                                                <div class="w-full bg-gray-200 rounded-full h-2">
                                                    <div class="bg-green-600 h-2 rounded-full transition-all duration-300" 
                                                         id="upload-progress" 
                                                         style="width: 100%"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" 
                                            onclick="removeFile()"
                                            class="ml-4 text-red-600 hover:text-red-800 transition">
                                        <i class="fas fa-times-circle text-2xl"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="lg:col-span-1 space-y-6">
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
                                   {{ old('status', $content->status) === 'draft' ? 'checked' : '' }}
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
                                   {{ old('status', $content->status) === 'published' ? 'checked' : '' }}
                                   class="mt-1">
                            <div class="ml-3">
                                <div class="font-medium text-gray-900">Published</div>
                                <div class="text-xs text-gray-500">Students can view and download</div>
                            </div>
                        </label>

                        <label class="flex items-start p-3 border rounded-lg cursor-pointer hover:bg-gray-50 transition">
                            <input type="radio" 
                                   name="status" 
                                   value="archived" 
                                   {{ old('status', $content->status) === 'archived' ? 'checked' : '' }}
                                   class="mt-1">
                            <div class="ml-3">
                                <div class="font-medium text-gray-900">Archived</div>
                                <div class="text-xs text-gray-500">Hidden from students</div>
                            </div>
                        </label>
                    </div>
                    @error('status')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Upload Statistics Card --}}
                <div class="bg-gradient-to-br from-green-50 to-emerald-50 rounded-2xl shadow-lg border border-green-100 p-6">
                    <h3 class="font-semibold text-gray-800 mb-4 flex items-center">
                        <i class="fas fa-chart-line text-green-600 mr-2"></i>
                        File Information
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Accepted Format:</span>
                            <span class="font-medium text-gray-800">PDF</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Max File Size:</span>
                            <span class="font-medium text-gray-800">10 MB</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Upload Status:</span>
                            <span class="font-medium text-green-600" id="upload-status">Ready</span>
                        </div>
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl shadow-lg border border-blue-100 p-6">
                    <button type="submit" 
                            id="upload-btn"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center mb-3">
                        <i class="fas fa-upload mr-2"></i>
                        Update Content
                    </button>
                    <a href="{{ route('instructor.courses.show', $course) }}" 
                       class="w-full bg-white hover:bg-gray-50 text-gray-700 font-semibold py-3 px-4 rounded-lg transition duration-200 flex items-center justify-center border border-gray-300">
                        <i class="fas fa-times mr-2"></i>
                        Cancel
                    </a>
                </div>
            </div>
        </div>
    </form>

    @push('styles')
    <style>
        .file-drop-zone {
            border: 2px dashed #d1d5db;
            border-radius: 12px;
            padding: 60px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #f9fafb;
        }

        .file-drop-zone:hover {
            border-color: #3b82f6;
            background-color: #eff6ff;
        }

        .file-drop-zone.dragover {
            border-color: #2563eb;
            background-color: #dbeafe;
            transform: scale(1.02);
        }

        .file-drop-content {
            pointer-events: none;
        }

        .hidden {
            display: none !important;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('content-upload-form');
            const fileInput = document.getElementById('file-input');
            const dropZone = document.getElementById('file-drop-zone');
            const filePreview = document.getElementById('file-preview');
            const uploadBtn = document.getElementById('upload-btn');
            const uploadStatus = document.getElementById('upload-status');

            // File input change handler
            fileInput.addEventListener('change', handleFileSelect);

            // Drag and drop functionality
            ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, preventDefaults, false);
                document.body.addEventListener(eventName, preventDefaults, false);
            });

            ['dragenter', 'dragover'].forEach(eventName => {
                dropZone.addEventListener(eventName, highlight, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropZone.addEventListener(eventName, unhighlight, false);
            });

            dropZone.addEventListener('drop', handleDrop, false);

            function preventDefaults(e) {
                e.preventDefault();
                e.stopPropagation();
            }

            function highlight() {
                dropZone.classList.add('dragover');
            }

            function unhighlight() {
                dropZone.classList.remove('dragover');
            }

            function handleDrop(e) {
                const dt = e.dataTransfer;
                const files = dt.files;

                if (files.length > 0) {
                    fileInput.files = files;
                    handleFileSelect({ target: { files: files } });
                }
            }

            function handleFileSelect(event) {
                const file = event.target.files[0];
                if (file) {
                    // Validate file type
                    if (file.type !== 'application/pdf') {
                        alert('Please select a PDF file only');
                        fileInput.value = '';
                        return;
                    }

                    // Validate file size (10MB limit)
                    if (file.size > 10 * 1024 * 1024) {
                        alert('File size must be less than 10MB');
                        fileInput.value = '';
                        return;
                    }

                    // Show file preview
                    showFilePreview(file);
                    uploadStatus.textContent = 'File Selected';
                    uploadStatus.classList.remove('text-green-600');
                    uploadStatus.classList.add('text-blue-600');
                }
            }

            function showFilePreview(file) {
                const fileName = document.getElementById('file-name');
                const fileSize = document.getElementById('file-size');

                fileName.textContent = file.name;
                fileSize.textContent = formatFileSize(file.size);
                filePreview.classList.remove('hidden');
                dropZone.classList.add('hidden');
            }

            window.removeFile = function() {
                fileInput.value = '';
                filePreview.classList.add('hidden');
                dropZone.classList.remove('hidden');
                uploadStatus.textContent = 'Ready';
                uploadStatus.classList.remove('text-blue-600');
                uploadStatus.classList.add('text-green-600');
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            // Form submission handler
            form.addEventListener('submit', function(e) {

                uploadBtn.disabled = true;
                uploadBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Updating...';
                uploadStatus.textContent = 'Updating...';
                uploadStatus.classList.remove('text-green-600', 'text-blue-600');
                uploadStatus.classList.add('text-yellow-600');
            });
        });
    </script>
    @endpush
@endsection