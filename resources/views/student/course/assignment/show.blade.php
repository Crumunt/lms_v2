@extends('layouts.student')

@section('content')
    {{-- Breadcrumbs --}}
    <nav class="flex mb-6 text-sm text-gray-500">
        <a href="{{ route('student.dashboard') }}" class="hover:text-gray-700">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ route('student.course.show', $course) }}" class="hover:text-gray-700">{{ $course->code }}</a>
        <span class="mx-2">/</span>
        <span class="font-medium text-gray-900">{{ $assignment->title }}</span>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Assignment Details Card --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                {{-- Header --}}
                <div class="mb-6">
                    <div class="flex items-start justify-between mb-4">
                        <h1 class="text-3xl font-bold text-gray-800">{{ $assignment->title }}</h1>
                        <span class="px-3 py-1 {{ $assignment->status_badge['class'] }} rounded-full text-sm font-medium">
                            {{ $assignment->status_badge['text'] }}
                        </span>
                    </div>

                    {{-- Meta Information --}}
                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                        <div class="flex items-center">
                            <i class="far fa-calendar text-gray-400 mr-2"></i>
                            <span>Due: <strong class="text-gray-800">{{ $assignment->formatted_due_date }}</strong></span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-star text-amber-500 mr-2"></i>
                            <span><strong class="text-gray-800">{{ $assignment->total_points }}</strong> points</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-upload text-blue-500 mr-2"></i>
                            <span class="capitalize">{{ str_replace('_', ' ', $assignment->submission_type) }}</span>
                        </div>
                    </div>

                    @if($assignment->is_urgent)
                        <div class="mt-4 bg-orange-50 border-l-4 border-orange-500 p-4 rounded-lg">
                            <div class="flex items-center">
                                <i class="fas fa-exclamation-triangle text-orange-600 mr-3"></i>
                                <p class="text-orange-800 font-medium">This assignment is due soon!</p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Description --}}
                @if($assignment->description)
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-info-circle text-blue-600 mr-2"></i>
                            Description
                        </h2>
                        <div class="prose max-w-none text-gray-700 bg-gray-50 p-4 rounded-lg">
                            {!! nl2br(e($assignment->description)) !!}
                        </div>
                    </div>
                @endif

                {{-- Instructions --}}
                @if($assignment->instructions)
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-clipboard-list text-purple-600 mr-2"></i>
                            Instructions
                        </h2>
                        <div class="prose max-w-none text-gray-700 bg-gray-50 p-4 rounded-lg">
                            {!! nl2br(e($assignment->instructions)) !!}
                        </div>
                    </div>
                @endif

                {{-- Attached Files --}}
                @if($assignment->attachments && count($assignment->attachments) > 0)
                    <div>
                        <h2 class="text-xl font-semibold text-gray-800 mb-3 flex items-center">
                            <i class="fas fa-paperclip text-green-600 mr-2"></i>
                            Attached Files
                        </h2>
                        <div class="space-y-2">
                            @foreach($assignment->attachments as $attachment)
                                <a href=""
                                    class="flex items-center justify-between p-4 bg-gray-50 hover:bg-gray-100 border border-gray-200 rounded-lg transition">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                            <i class="fas fa-file-pdf text-blue-600"></i>
                                        </div>
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $attachment->filename }}</p>
                                            <p class="text-xs text-gray-500">{{ $attachment->size }}</p>
                                        </div>
                                    </div>
                                    <i class="fas fa-download text-gray-400"></i>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            {{-- Submission Section --}}
            @if($assignment->is_submitted)
                {{-- Show Existing Submission --}}
                <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                    <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-check-circle text-green-600 mr-2"></i>
                        Your Submission
                    </h2>

                    <div class="bg-green-50 border border-green-200 rounded-lg p-6 mb-6">
                        <div class="flex items-start">
                            <i class="fas fa-check-circle text-green-600 text-2xl mr-4"></i>
                            <div>
                                <h3 class="font-semibold text-green-900 mb-1">Submitted Successfully</h3>
                                <p class="text-sm text-green-800">
                                    Submitted on {{ $submission->created_at }}
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- Submitted File --}}
                    @if($submission->file_path)
                        <div class="mb-6">
                            <h3 class="font-medium text-gray-700 mb-3">Submitted File:</h3>
                            <div class="flex items-center justify-between p-4 bg-gray-50 border border-gray-200 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-file text-blue-600"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-800">{{ basename($submission->file_path) }}</p>
                                        <p class="text-xs text-gray-500">{{ $submission->created_at->diffForHumans() }}</p>
                                    </div>
                                </div>
                                <a href=""
                                    class="text-blue-600 hover:text-blue-700">
                                    
                                </a>
                            </div>
                        </div>
                    @endif

                    {{-- Grade (if graded) --}}
                    @if($submission->grade !== null)
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                            <h3 class="font-semibold text-blue-900 mb-3">Grade</h3>
                            <div class="flex items-baseline">
                                <span class="text-4xl font-bold text-blue-600">{{ $submission->grade }}</span>
                                <span class="text-2xl text-gray-500 ml-2">/ {{ $assignment->total_points }}</span>
                            </div>
                            @if($submission->feedback)
                                <div class="mt-4 pt-4 border-t border-blue-200">
                                    <h4 class="font-medium text-blue-900 mb-2">Instructor Feedback:</h4>
                                    <p class="text-sm text-blue-800">{{ $submission->feedback }}</p>
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                            <div class="flex items-center">
                                <i class="fas fa-clock text-yellow-600 mr-3"></i>
                                <p class="text-yellow-800 text-sm">Waiting for instructor to grade your submission.</p>
                            </div>
                        </div>
                    @endif
                </div>
            @else
                {{-- Submit Assignment Form --}}
                @if(!$assignment->due_date->isPast() || $assignment->allow_late_submission)
                    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-8">
                        <h2 class="text-xl font-semibold text-gray-800 mb-6 flex items-center">
                            <i class="fas fa-upload text-blue-600 mr-2"></i>
                            Submit Assignment
                        </h2>

                        @if($assignment->due_date->isPast() && $assignment->allow_late_submission)
                            <div class="mb-6 bg-orange-50 border-l-4 border-orange-500 p-4 rounded-lg">
                                <div class="flex items-center">
                                    <i class="fas fa-exclamation-triangle text-orange-600 mr-3"></i>
                                    <p class="text-orange-800 text-sm">
                                        <strong>Late Submission:</strong> This assignment was due on
                                        {{ $assignment->due_date->format('M d, Y') }}, but late submissions are allowed.
                                    </p>
                                </div>
                            </div>
                        @endif

                        <form action="{{ route('student.course.assignment.store', [$course, $assignment]) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf

                            @if($assignment->submission_type === 'file' || $assignment->submission_type === 'both')
                                <div class="mb-6">
                                    <label for="file" class="block text-sm font-medium text-gray-700 mb-2">
                                        Upload File <span class="text-red-500">*</span>
                                    </label>
                                    <div
                                        class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-blue-500 transition">
                                        <input type="file" name="file" id="file" class="hidden"
                                            accept=".pdf,.doc,.docx,.ppt,.pptx,.zip,.rar" required>
                                        <label for="file" class="cursor-pointer">
                                            <i class="fas fa-cloud-upload-alt text-4xl text-gray-400 mb-4"></i>
                                            <p class="text-gray-700 font-medium mb-1">Click to upload or drag and drop</p>
                                            <p class="text-sm text-gray-500">PDF, DOC, DOCX, PPT, PPTX, ZIP, RAR (Max 10MB)</p>
                                        </label>
                                    </div>
                                    <div id="file-info" class="mt-3 hidden">
                                        <div class="flex items-center justify-between p-3 bg-blue-50 border border-blue-200 rounded-lg">
                                            <div class="flex items-center space-x-3">
                                                <i class="fas fa-file text-blue-600"></i>
                                                <span id="file-name" class="text-sm font-medium text-gray-800"></span>
                                            </div>
                                            <button type="button" onclick="clearFile()" class="text-red-600 hover:text-red-700">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </div>
                                    @error('file')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif

                            @if($assignment->submission_type === 'text' || $assignment->submission_type === 'both')
                                <div class="mb-6">
                                    <label for="content" class="block text-sm font-medium text-gray-700 mb-2">
                                        Your Answer {{ $assignment->submission_type === 'text' ? '*' : '(Optional)' }}
                                    </label>
                                    <textarea name="content" id="content" rows="8"
                                        class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 @error('content') border-red-500 @enderror"
                                        placeholder="Type your answer here..." {{ $assignment->submission_type === 'text' ? 'required' : '' }}>{{ old('content') }}</textarea>
                                    @error('content')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            @endif

                            {{-- Submit Button --}}
                            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                                <a href="{{ route('student.course.show', $course) }}" class="text-gray-600 hover:text-gray-800">
                                    <i class="fas fa-arrow-left mr-2"></i>Back to Course
                                </a>
                                <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition duration-200 flex items-center">
                                    <i class="fas fa-paper-plane mr-2"></i>
                                    Submit Assignment
                                </button>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="bg-white rounded-2xl shadow-lg border border-red-200 p-8">
                        <div class="text-center">
                            <i class="fas fa-lock text-red-400 text-5xl mb-4"></i>
                            <h3 class="text-xl font-semibold text-gray-800 mb-2">Submission Closed</h3>
                            <p class="text-gray-600">
                                The deadline for this assignment has passed and late submissions are not allowed.
                            </p>
                        </div>
                    </div>
                @endif
            @endif
        </div>

        {{-- Sidebar --}}
        <div class="lg:col-span-1 space-y-6">
            {{-- Quick Info Card --}}
            <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Quick Info</h3>

                <div class="space-y-4">
                    <div>
                        <p class="text-sm text-gray-500 mb-1">Course</p>
                        <p class="font-medium text-gray-800">{{ $course->code }} - {{ $course->title }}</p>
                    </div>

                    <div class="pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-500 mb-1">Due Date</p>
                        <p class="font-medium text-gray-800">{{ $assignment->due_date->format('M d, Y') }}</p>
                        <p class="text-xs text-gray-500">{{ $assignment->due_date->format('h:i A') }}</p>
                    </div>

                    <div class="pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-500 mb-1">Points</p>
                        <p class="font-medium text-gray-800">{{ $assignment->total_points }} points</p>
                    </div>

                    <div class="pt-4 border-t border-gray-200">
                        <p class="text-sm text-gray-500 mb-1">Submission Type</p>
                        <p class="font-medium text-gray-800 capitalize">
                            {{ str_replace('_', ' ', $assignment->submission_type) }}</p>
                    </div>

                    @if($assignment->allow_late_submission)
                        <div class="pt-4 border-t border-gray-200">
                            <div class="flex items-center text-green-600">
                                <i class="fas fa-check-circle mr-2"></i>
                                <span class="text-sm font-medium">Late submissions allowed</span>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // File upload handler
            const fileInput = document.getElementById('file');
            const fileInfo = document.getElementById('file-info');
            const fileName = document.getElementById('file-name');

            if (fileInput) {
                fileInput.addEventListener('change', function () {
                    if (this.files.length > 0) {
                        fileName.textContent = this.files[0].name;
                        fileInfo.classList.remove('hidden');
                    } else {
                        fileInfo.classList.add('hidden');
                    }
                });
            }

            function clearFile() {
                fileInput.value = '';
                fileInfo.classList.add('hidden');
            }

            // Drag and drop
            const dropZone = document.querySelector('.border-dashed');
            if (dropZone) {
                ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, preventDefaults, false);
                });

                function preventDefaults(e) {
                    e.preventDefault();
                    e.stopPropagation();
                }

                ['dragenter', 'dragover'].forEach(eventName => {
                    dropZone.addEventListener(eventName, highlight, false);
                });

                ['dragleave', 'drop'].forEach(eventName => {
                    dropZone.addEventListener(eventName, unhighlight, false);
                });

                function highlight(e) {
                    dropZone.classList.add('border-blue-500', 'bg-blue-50');
                }

                function unhighlight(e) {
                    dropZone.classList.remove('border-blue-500', 'bg-blue-50');
                }

                dropZone.addEventListener('drop', handleDrop, false);

                function handleDrop(e) {
                    const dt = e.dataTransfer;
                    const files = dt.files;
                    fileInput.files = files;

                    if (files.length > 0) {
                        fileName.textContent = files[0].name;
                        fileInfo.classList.remove('hidden');
                    }
                }
            }

            // Confirm before submit
            document.querySelector('form')?.addEventListener('submit', function (e) {
                if (!confirm('Are you sure you want to submit this assignment? You cannot edit it after submission.')) {
                    e.preventDefault();
                }
            });
        </script>
    @endpush
@endsection