@props([
    'assignments'
])

<section>
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-800">
            <i class="fas fa-clipboard-check mr-3 text-orange-600"></i>
            Pending Assignments
        </h2>
    </div>
    
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
    <div class="p-6">
        <div class="space-y-4">
            @forelse($assignments as $assignment)
                <div class="flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-50 transition border border-gray-100">
                    <div class="w-12 h-12 rounded-full flex items-center justify-center 
                        {{ $assignment['priority'] === 'high' ? 'bg-red-100' : ($assignment['priority'] === 'medium' ? 'bg-yellow-100' : 'bg-green-100') }}">
                        <i class="fas fa-file-alt 
                            {{ $assignment['priority'] === 'high' ? 'text-red-600' : ($assignment['priority'] === 'medium' ? 'text-yellow-600' : 'text-green-600') }}">
                        </i>
                    </div>

                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-medium text-gray-800">{{ $assignment->title }}</h3>
                            <span class="text-xs px-2 py-1 rounded-full 
                                {{ $assignment->status === 'pending' ? 'bg-red-100 text-red-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ ucfirst($assignment['status']) }}
                            </span>
                        </div>
                        <p class="text-xs text-gray-500 mb-1">{{ $assignment->course?->title }}</p>

                        <div class="flex items-center justify-between">
                            <p class="text-xs text-gray-400">Due: {{ $assignment->due_date->diffForHumans() }}</p>
                            <p class="text-xs text-gray-600">{{ $assignment->submissions->count() }} submitted</p>
                        </div>

                        <div class="mt-2">
                            <div class="w-full bg-gray-200 rounded-full h-1.5">
                                <div class="bg-purple-600 h-1.5 rounded-full" 
                                     style="">
                                </div>
                            </div>
                        </div>
                    </div>

                    <a href="{{ route('instructor.courses.assignments.show', [$assignment->course, $assignment]) }}" class="text-purple-600 hover:text-purple-800 transition" {{-- add view assignment button --}}>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
                @empty
                    <div class="p-6 text-center text-gray-500">
                        <i class="fas fa-info-circle text-gray-400 text-lg mb-2"></i>
                        <p>No assignments found.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

</section>
