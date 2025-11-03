@props(['assignments'])
<div>
    {{-- Filter Bar --}}
    <div class="bg-white rounded-xl shadow-lg border border-gray-100 p-4 mb-6">
        <div class="flex flex-wrap items-center gap-4">
            <div class="flex-1 min-w-[250px]">
                <div class="relative">
                    <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    <input type="text" 
                            id="search" 
                            placeholder="Search assignments..." 
                            class="w-full pl-10 pr-4 py-2 rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200"
                            wire:model="search">
                </div>
            </div>
        </div>
    </div>

    {{-- Assignments Grid --}}
    <div class="grid grid-cols-1 gap-6" id="assignments-container">
        @foreach($assignments as $assignment)
            <div class="bg-white rounded-xl shadow-lg border border-gray-100 hover:shadow-xl transition-all duration-200 assignment-card" 
                    data-status="{{ $assignment->status }}"
                    data-title="{{ strtolower($assignment->title) }}">
                <div class="p-6">
                    <div class="flex flex-col lg:flex-row lg:items-start lg:justify-between gap-6">
                        {{-- Left: Assignment Info --}}
                        <div class="flex-1">
                            <div class="flex items-start gap-4 mb-4">
                                {{-- Icon --}}
                                <div class="flex-shrink-0">
                                    <div class="w-14 h-14 rounded-xl bg-gradient-to-br {{ $assignment->status === 'published' ? 'from-green-400 to-green-600' : ($assignment->status === 'draft' ? 'from-amber-400 to-amber-600' : 'from-gray-400 to-gray-600') }} flex items-center justify-center shadow-lg">
                                        <i class="fas {{ $assignment->submission_type === 'file' ? 'fa-file-upload' : ($assignment->submission_type === 'text' ? 'fa-keyboard' : 'fa-tasks') }} text-white text-xl"></i>
                                    </div>
                                </div>

                                {{-- Title & Meta --}}
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-3 mb-2 flex-wrap">
                                        <h3 class="text-xl font-bold text-gray-900">
                                            <a href="{{ route('instructor.courses.assignments.show', [$course, $assignment]) }}" 
                                                class="hover:text-blue-600 transition-colors">
                                                {{ $assignment->title }}
                                            </a>
                                        </h3>

                                        {{-- Status Badge --}}
                                        @if($assignment->status === 'published')
                                            <span class="inline-flex items-center px-3 py-1 bg-green-100 text-green-800 text-xs font-semibold rounded-full">
                                                <i class="fas fa-check-circle mr-1"></i>
                                                Published
                                            </span>
                                        @elseif($assignment->status === 'draft')
                                            <span class="inline-flex items-center px-3 py-1 bg-amber-100 text-amber-800 text-xs font-semibold rounded-full">
                                                <i class="fas fa-edit mr-1"></i>
                                                Draft
                                            </span>
                                        @else
                                            <span class="inline-flex items-center px-3 py-1 bg-gray-100 text-gray-800 text-xs font-semibold rounded-full">
                                                <i class="fas fa-lock mr-1"></i>
                                                Closed
                                            </span>
                                        @endif

                                        {{-- Overdue Badge --}}
                                        @if($assignment->isOverdue() && $assignment->status === 'published')
                                            <span class="inline-flex items-center px-3 py-1 bg-red-100 text-red-800 text-xs font-semibold rounded-full">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                                Overdue
                                            </span>
                                        @endif
                                    </div>

                                    {{-- Description --}}
                                    @if($assignment->description)
                                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                            {{ Str::limit($assignment->description, 150) }}
                                        </p>
                                    @endif

                                    {{-- Meta Info --}}
                                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                                        <div class="flex items-center">
                                            <i class="fas fa-calendar-alt mr-2 text-blue-500"></i>
                                            <span>
                                                @if($assignment->due_date)
                                                    <span class="font-medium">{{ $assignment->due_date->format('M d, Y') }}</span>
                                                    <span class="text-xs text-gray-500 ml-1">({{ $assignment->due_date->diffForHumans() }})</span>
                                                @else
                                                    <span class="text-gray-400">No due date</span>
                                                @endif
                                            </span>
                                        </div>

                                        <div class="flex items-center">
                                            <i class="fas fa-star mr-2 text-amber-500"></i>
                                            <span class="font-medium">{{ $assignment->total_points }} points</span>
                                        </div>

                                        <div class="flex items-center">
                                            <i class="fas fa-upload mr-2 text-purple-500"></i>
                                            <span>{{ ucfirst($assignment->submission_type) }}</span>
                                        </div>

                                        @if($assignment->allow_late_submission)
                                            <div class="flex items-center text-green-600">
                                                <i class="fas fa-clock mr-2"></i>
                                                <span>Late allowed</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Right: Stats & Actions --}}
                        <div class="flex lg:flex-col items-center lg:items-end gap-4">
                            {{-- Submission Stats --}}
                            <a href="" 
                            class="text-center hover:scale-105 transition-transform">
                                <div class="text-4xl font-bold text-blue-600">
                                    {{ $assignment->submissions_count }}
                                </div>
                                <p class="text-xs text-gray-600 uppercase tracking-wide">Submissions</p>
                                
                                <div class="mt-2 flex gap-3 text-xs">
                                    <div>
                                        <span class="font-semibold text-green-600">{{ $assignment->graded_submissions_count ?? 0 }}</span>
                                        <span class="text-gray-500">graded</span>
                                    </div>
                                    <div>
                                        <span class="font-semibold text-amber-600">{{ $assignment->pending_submissions_count ?? 0 }}</span>
                                        <span class="text-gray-500">pending</span>
                                    </div>
                                </div>
                            </a>

                            {{-- Quick Actions Dropdown --}}
                            <div class="relative" x-data="{ open: false }">
                                <button @click="open = !open" 
                                        class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                                    <i class="fas fa-ellipsis-v text-gray-600"></i>
                                </button>
                                
                                <div x-show="open" 
                                        @click.away="open = false"
                                        x-transition
                                        class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 py-2 z-10">
                                    <a href="{{ route('instructor.courses.assignments.show', [$course, $assignment]) }}" 
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                                        <i class="fas fa-eye w-5"></i> View Details
                                    </a>
                                    <a href="{{ route('instructor.courses.assignments.edit', [$course, $assignment]) }}" 
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                                        <i class="fas fa-edit w-5"></i> Edit
                                    </a>
                                    <a href="}" 
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                                        <i class="fas fa-clipboard-list w-5"></i> Submissions
                                    </a>
                                    <hr class="my-2">
                                    <form action="{{ route('instructor.courses.assignments.destroy', [$course, $assignment]) }}" 
                                            method="POST" 
                                            onsubmit="return confirm('Are you sure? This will delete the assignment and all submissions.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                            <i class="fas fa-trash w-5"></i> Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Action Buttons (Mobile/Desktop) --}}
                    <div class="mt-6 pt-4 border-t border-gray-200 flex flex-wrap gap-2">
                        <a href="{{ route('instructor.courses.assignments.show', [$course, $assignment]) }}" 
                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                            <i class="fas fa-eye mr-2"></i>
                            View Details
                        </a>

                        <a href="{{ route('instructor.courses.assignments.edit', [$course, $assignment]) }}" 
                            class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-200 transition-colors">
                            <i class="fas fa-edit mr-2"></i>
                            Edit
                        </a>

                        @if($assignment->submissions_count > 0)
                            <a href="" 
                            class="inline-flex items-center px-4 py-2 bg-purple-100 text-purple-700 text-sm font-medium rounded-lg hover:bg-purple-200 transition-colors">
                                <i class="fas fa-clipboard-list mr-2"></i>
                                Submissions
                                @if(($assignment->pending_submissions_count ?? 0) > 0)
                                    <span class="ml-2 px-2 py-0.5 bg-purple-600 text-white text-xs rounded-full">
                                        {{ $assignment->pending_submissions_count }}
                                    </span>
                                @endif
                            </a>
                        @endif

                        <form action="{{ route('instructor.courses.assignments.destroy', [$course, $assignment]) }}" 
                                method="POST" 
                                onsubmit="return confirm('Are you sure you want to delete this assignment? This action cannot be undone.');"
                                class="ml-auto">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="inline-flex items-center px-4 py-2 bg-red-100 text-red-700 text-sm font-medium rounded-lg hover:bg-red-200 transition-colors">
                                <i class="fas fa-trash mr-2"></i>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
