@extends('layouts.instructor')
@section('content')

    <div class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $courseData['title'] }}</h1>
                <p class="text-gray-600 mt-2">{{ $courseData['code'] }} • {{ $courseData['enrollment_count'] }} students</p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('instructor.courses.edit', ['course' => $courseData['id']]) }}" class="btn-secondary">
                    <i class="fas fa-edit mr-2"></i>
                    Edit Course
                </a>
                <button class="btn-primary">
                    <i class="fas fa-plus mr-2"></i>
                    New Assignment
                </button>
            </div>
        </div>

        <!-- Course Overview -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="text-3xl font-bold text-blue-600">{{ $courseData['enrollment_count'] }}</div>
                    <div class="text-sm text-gray-500">Total Students</div>
                </div>
                <div class="text-center">
                    <div class="text-3xl font-bold text-green-600">{{ $courseData['assignments'] }}</div>
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
            <p class="text-gray-600">{!! $courseData['description'] !!}</p>
        </div>
        <!-- Students Table -->
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-800">Enrolled Students</h2>
            </div>
            @livewire('instructor.course.enrolled-students-table', ['courseId' => $courseData['id']])
        </div>

        <!-- Course Materials (Instructor-managed content) -->
        <div id="materials" class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6 mb-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-800">Course Materials</h2>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <h3 class="font-semibold text-gray-700 mb-3">Upload New Content (PDF)</h3>
                    <form id="content-upload-form" enctype="multipart/form-data" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Content Title <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="title"
                                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                placeholder="Week 1 - Introduction" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Content Description <span
                                    class="text-red-500">*</span></label>
                            <textarea name="description" rows="3"
                                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-transparent"
                                placeholder="Overview of week 1 topics..." required></textarea>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select name="status"
                                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-green-500 focus:border-transparent">
                                <option value="draft">Draft</option>
                                <option value="published">Published</option>
                                <option value="archived">Archived</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">PDF File <span
                                    class="text-red-500">*</span></label>
                            <div class="file-upload-area">
                                <div class="file-drop-zone" id="file-drop-zone"
                                    onclick="document.getElementById('file-input').click()">
                                    <div class="file-drop-content">
                                        <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-3"></i>
                                        <h5 class="text-gray-600 font-medium">Drop PDF file here or click to browse</h5>
                                        <p class="text-gray-500 text-sm">Maximum file size: 5MB</p>
                                    </div>
                                </div>
                                <input type="file" id="file-input" name="file" accept=".pdf" class="hidden" required>
                            </div>

                            <!-- File Preview -->
                            <div id="file-preview" class="file-preview hidden mt-3">
                                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                                    <div class="flex items-center">
                                        <i class="fas fa-file-pdf text-2xl text-red-600 mr-3"></i>
                                        <div class="flex-1">
                                            <h6 class="font-medium text-gray-800" id="file-name">filename.pdf</h6>
                                            <small class="text-gray-600" id="file-size">File size</small>
                                        </div>
                                        <button type="button" class="text-red-600 hover:text-red-800"
                                            onclick="removeFile()">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button class="btn-primary w-full" type="submit" id="upload-btn">
                            <i class="fas fa-upload mr-2"></i>Upload Content
                        </button>
                    </form>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-700 mb-3">Existing Contents</h3>
                    <div class="space-y-3">
                        @forelse(($contents ?? []) as $item)
                            <div class="p-4 border border-gray-200 rounded-xl hover:bg-gray-50 transition">
                                <div class="flex items-start justify-between">
                                    <div class="flex-1 pr-4">
                                        <div class="flex items-center space-x-2 mb-1">
                                            <i class="fas fa-file-pdf text-red-600"></i>
                                            <h4 class="text-sm font-semibold text-gray-800">{{ $item['title'] }}</h4>
                                            <span
                                                class="text-xs px-2 py-1 rounded-full {{ $item['status'] === 'published' ? 'bg-green-100 text-green-800' : ($item['status'] === 'draft' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800') }}">{{ ucfirst($item['status']) }}</span>
                                        </div>
                                        <p class="text-xs text-gray-600 mb-2">{{ $item['description'] }}</p>
                                        <p class="text-xs text-gray-400">Uploaded: {{ $item['uploaded_at'] }}</p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        <a href=""
                                            target="_blank" class="text-blue-600 hover:text-blue-800 text-sm">
                                            <i class="fas fa-download mr-1"></i>Download
                                        </a>
                                        <button
                                            class="text-gray-600 hover:text-gray-800 text-sm">
                                            <i class="fas fa-edit mr-1"></i>Edit
                                        </button>
                                        <form method="POST"
                                            onsubmit="return confirm('Delete this content?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:text-red-800 text-sm">
                                                <i class="fas fa-trash mr-1"></i>Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div id="edit-{{ $item['id'] }}" class="mt-4 hidden">
                                    <form method="POST"
                                        enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        @csrf
                                        @method('PUT')
                                        @php
                                            $editTitleProps = [
                                                "name" => "title",
                                                "label" => "Title",
                                                "defaultValue" => $item["title"],
                                                "required" => true
                                            ];
                                        @endphp
                                        <div data-react-component="TextInput" data-props='@json($editTitleProps)'></div>
                                        @php
                                            $editStatusOptions = [
                                                ["label" => "Draft", "value" => "draft"],
                                                ["label" => "Published", "value" => "published"],
                                                ["label" => "Archived", "value" => "archived"],
                                            ];
                                            $editStatusDefault = collect($editStatusOptions)->firstWhere('value', $item['status']);
                                            $editStatusProps = ["name" => "status", "label" => "Status", "options" => $editStatusOptions, "defaultValue" => $editStatusDefault, "sx" => ["width" => "100%"]];
                                        @endphp
                                        <div data-react-component="SelectAutocomplete" data-props='@json($editStatusProps)'>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Description</label>
                                            <textarea name="description" rows="2"
                                                class="w-full border border-gray-300 rounded-lg p-2"
                                                required>{{ $item['description'] }}</textarea>
                                        </div>
                                        <div class="md:col-span-2">
                                            <label class="block text-xs font-medium text-gray-700 mb-1">Replace PDF
                                                (optional)</label>
                                            <input type="file" name="file" accept="application/pdf"
                                                class="w-full border border-gray-300 rounded-lg p-2 bg-white">
                                        </div>
                                        <div>
                                            <button class="btn-primary" type="submit"><i
                                                    class="fas fa-save mr-1"></i>Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No content uploaded yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
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