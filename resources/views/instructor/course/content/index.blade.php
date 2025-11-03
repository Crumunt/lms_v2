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
        <span class="font-medium text-gray-900">Course Contents</span>
    </nav>

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Course Contents</h1>
            <p class="text-gray-600 mt-2">{{ $course->code }} - {{ $course->title }}</p>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('instructor.courses.content.create', $course) }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                <i class="fas fa-plus mr-2"></i>
                Upload Content
            </a>
            <a href="{{ route('instructor.courses.show', $course) }}"
                class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">
                <i class="fas fa-arrow-left mr-2"></i>
                Back to Course
            </a>
        </div>
    </div>

    {{-- Statistics Card --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Total Contents</p>
                    <h3 class="text-3xl font-bold text-gray-800">{{ $contents->total }}</h3>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-file-pdf text-blue-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Published</p>
                    <h3 class="text-3xl font-bold text-green-600">{{ $contents->published }}</h3>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Draft</p>
                    <h3 class="text-3xl font-bold text-yellow-600">{{ $contents->draft }}</h3>
                </div>
                <div class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-edit text-yellow-600 text-xl"></i>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-gray-600 mb-1">Archived</p>
                    <h3 class="text-3xl font-bold text-gray-600">{{ $contents->archived }}</h3>
                </div>
                <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-archive text-gray-600 text-xl"></i>
                </div>
            </div>
        </div>
    </div>

    {{-- Contents List --}}
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-800 flex items-center">
                <i class="fas fa-folder-open text-blue-600 mr-2"></i>
                All Course Materials
            </h2>
            <div class="flex gap-2">
                
            </div>
        </div>

        <div class="space-y-4">
            @forelse ($course_content as $content)
                <div class="border border-gray-200 rounded-xl hover:shadow-md transition p-5">
                    <div class="flex items-start justify-between">
                        <div class="flex items-start flex-1">
                            {{-- PDF Icon --}}
                            <div class="flex-shrink-0 w-14 h-14 bg-red-100 rounded-lg flex items-center justify-center mr-4">
                                <i class="fas fa-file-pdf text-red-600 text-2xl"></i>
                            </div>

                            {{-- Content Info --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="text-lg font-semibold text-gray-800">{{ $content->title }}</h3>

                                    {{-- Status Badge --}}
                                    @if($content->status === 'published')
                                        <span class="px-3 py-1 bg-green-100 text-green-700 text-xs font-medium rounded-full">
                                            <i class="fas fa-check-circle mr-1"></i>Published
                                        </span>
                                    @elseif($content->status === 'draft')
                                        <span class="px-3 py-1 bg-yellow-100 text-yellow-700 text-xs font-medium rounded-full">
                                            <i class="fas fa-edit mr-1"></i>Draft
                                        </span>
                                    @else
                                        <span class="px-3 py-1 bg-gray-100 text-gray-700 text-xs font-medium rounded-full">
                                            <i class="fas fa-archive mr-1"></i>Archived
                                        </span>
                                    @endif
                                </div>

                                <p class="text-gray-600 text-sm mb-3">{{ $content->description }}</p>

                                <div class="flex items-center gap-4 text-xs text-gray-500">
                                    <span>
                                        <i class="fas fa-calendar mr-1"></i>
                                        Uploaded {{ $content->created_at->diffForHumans() }}
                                    </span>
                                    @if($content->file_size)
                                        <span>
                                            <i class="fas fa-file mr-1"></i>
                                            {{ number_format($content->file_size / 1024 / 1024, 2) }} MB
                                        </span>
                                    @endif
                                    @if($content->download_count)
                                        <span>
                                            <i class="fas fa-download mr-1"></i>
                                            {{ $content->download_count }} downloads
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div class="flex items-center gap-2 ml-4">
                            <a class="inline-flex items-center px-3 py-2 bg-emerald-50 text-emerald-600 rounded-lg hover:bg-emerald-100 transition text-sm"
                                href="{{ Storage::url($content->file_path) }}" target="_blank">
                                <i class="fas fa-eye mr-1"></i>
                                View PDF
                            </a>
                            <a href=""
                                class="inline-flex items-center px-3 py-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition text-sm">
                                <i class="fas fa-download mr-1"></i>
                                Download
                            </a>
                            <a href="{{ route('instructor.courses.content.edit', [$course, $content]) }}"
                                class="inline-flex items-center px-3 py-2 bg-gray-50 text-gray-600 rounded-lg hover:bg-gray-100 transition text-sm">
                                <i class="fas fa-edit mr-1"></i>
                                Edit
                            </a>
                            <form action="{{ route('instructor.courses.content.destroy', [$course, $content]) }}" method="POST"
                                class="inline"
                                onsubmit="return confirm('Are you sure you want to delete this content? This action cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="inline-flex items-center px-3 py-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition text-sm">
                                    <i class="fas fa-trash mr-1"></i>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <i class="fas fa-folder-open text-gray-300 text-6xl mb-4"></i>
                    <h3 class="text-lg font-medium text-gray-600 mb-2">No Content Yet</h3>
                    <p class="text-gray-500 mb-6">Start by uploading your first course material</p>
                    <a href="{{ route('instructor.courses.content.create', $course) }}"
                        class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i>
                        Upload First Content
                    </a>
                </div>
            @endforelse

            {{-- Pagination (optional) --}}
            @if(false)
                <div class="mt-6">
                    {{ $course_content->links() }}
                </div>
            @endif
        </div>

    </div>
@endsection