@extends('layouts.instructor')
@section('content')

    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $course->title }}</h1>
                <p class="text-gray-600 mt-2">{{ $course->code }} • {{ $course->enrollment_count }} students</p>
            </div>
            <div class="flex space-x-3">
                @can('update', [\App\Models\Course::class, $course])
                    <a href="{{ route('instructor.courses.edit', $course) }}" class="btn-secondary">
                        <i class="fas fa-edit mr-2"></i>
                        Edit Course
                    </a>
                @endcan
                @can('create', \App\Models\Course::class)
                    <a href="{{ route('instructor.courses.assignments.index', $course) }}" class="btn-primary">
                        <i class="fas fa-pen mr-2"></i>
                        Assignments
                    </a>
                    <a href="{{ route('instructor.courses.content.index', $course) }}" class="btn-primary">
                        <i class="fas fa-book mr-2"></i>
                        Course Contents
                    </a>
                @endcan
            </div>
        </div>

        <!-- Course Overview -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600">{{ $course->enrollment_count }}</div>
                    <div class="text-sm text-gray-500">Total Students</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-green-600">{{ $course->assignments_count }}</div>
                    <div class="text-sm text-gray-500">Assignments</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-slate-600">0</div>
                    <div class="text-sm text-gray-500">Course Content</div>
                </div>
            </div>
        </div>
        <!-- Course Description -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Course Description</h2>
            <p class="text-gray-600">{!! $course->description !!}</p>
        </div>
        <!-- Students Table -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">Enrolled Students</h2>
            </div>
            @livewire('instructor.course.enrolled-students-table', ['courseId' => $course->id])
        </div>



    </div>

    <style>
        /* File Upload Styles */
        .file-upload-area {
            margin-bottom: 15px;
        }

        .file-drop-zone {
            border: 2px dashed #e5e7eb;
            border-radius: 8px;
            padding: 40px 20px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background-color: #f9fafb;
        }

        .file-drop-zone:hover {
            border-color: #10b981;
            background-color: #f0fdf4;
        }

        .file-drop-zone.dragover {
            border-color: #10b981;
            background-color: #ecfdf5;
        }

        .file-drop-content i {
            display: block;
            margin: 0 auto 15px;
        }

        .file-preview {
            margin-top: 15px;
        }

        .hidden {
            display: none !important;
        }
    </style>

    <script>
        // File upload functionality
        document.addEventListener('DOMContentLoaded', function () {
            const form = document.getElementById('content-upload-form');
            const fileInput = document.getElementById('file-input');
            const dropZone = document.getElementById('file-drop-zone');
            const filePreview = document.getElementById('file-preview');
            const uploadBtn = document.getElementById('upload-btn');

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

            // Form submission
            form.addEventListener('submit', function (e) {
                e.preventDefault();

                if (!fileInput.files.length) {
                    alert('Please select a PDF file');
                    return;
                }

                const formData = new FormData(form);
                const courseId = '{{ request()->route("id") }}';


                uploadBtn.disabled = true;
                uploadBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Uploading...';

                fetch(`/instructor/courses/${courseId}/contents`, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showNotification('Content uploaded successfully!', 'success');
                            form.reset();
                            removeFile();
                            // Reload page to show new content
                            setTimeout(() => {
                                window.location.reload();
                            }, 1500);
                        } else {
                            showNotification(data.message || 'Upload failed', 'error');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showNotification('Upload failed. Please try again.', 'error');
                    })
                    .finally(() => {
                        uploadBtn.disabled = false;
                        uploadBtn.innerHTML = '<i class="fas fa-upload mr-2"></i>Upload Content';
                    });
            });

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

                    // Validate file size (5MB limit)
                    if (file.size > 5 * 1024 * 1024) {
                        alert('File size must be less than 5MB');
                        fileInput.value = '';
                        return;
                    }

                    // Show file preview
                    showFilePreview(file);
                }
            }

            function showFilePreview(file) {
                const fileName = document.getElementById('file-name');
                const fileSize = document.getElementById('file-size');

                fileName.textContent = file.name;
                fileSize.textContent = formatFileSize(file.size);
                filePreview.classList.remove('hidden');
                dropZone.style.display = 'none';
            }

            window.removeFile = function () {
                fileInput.value = '';
                filePreview.classList.add('hidden');
                dropZone.style.display = 'block';
            }

            function formatFileSize(bytes) {
                if (bytes === 0) return '0 Bytes';
                const k = 1024;
                const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                const i = Math.floor(Math.log(bytes) / Math.log(k));
                return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
            }

            function showNotification(message, type) {
                const notification = document.createElement('div');
                notification.className = `fixed top-4 right-4 p-4 rounded-lg shadow-lg z-50 transform translate-x-full transition-transform duration-300 ${type === 'success' ? 'bg-green-500 text-white' :
                    type === 'error' ? 'bg-red-500 text-white' :
                        'bg-blue-500 text-white'
                    }`;
                notification.textContent = message;
                document.body.appendChild(notification);

                // Animate in
                setTimeout(() => {
                    notification.style.transform = 'translateX(0)';
                }, 100);

                setTimeout(() => {
                    notification.style.transform = 'translateX(100%)';
                    setTimeout(() => {
                        notification.remove();
                    }, 300);
                }, 3000);
            }
        });
    </script>
@endsection