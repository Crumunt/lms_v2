<div>
    {{-- Success Message --}}
    @if ($message)
        <div
            class="mb-4 bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg flex items-center justify-between">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <span>{{ $message }}</span>
            </div>
            <button wire:click="dismissMessage" class="text-green-600 hover:text-green-800">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    {{-- Submissions Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Student
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Submitted
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Status
                    </th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Score
                    </th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                        Actions
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($submissions as $submission)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <span class="text-blue-600 font-medium text-sm">
                                            {{ substr(strtoupper( $submission->student->detail?->full_name), 0,2) }}
                                        </span>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-medium text-gray-900">
                                        {{ $submission->student->detail?->full_name }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $submission->student->email }}
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">
                                {{ $submission->submitted_at->format('M d, Y') }}
                            </div>
                            <div class="text-sm text-gray-500">
                                {{ $submission->submitted_at->format('h:i A') }}
                            </div>
                            @if($submission->is_late)
                                <span
                                    class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800 mt-1">
                                    Late
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($submission->status === 'submitted')
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Pending Review
                                </span>
                            @elseif($submission->status === 'graded')
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Graded
                                </span>
                            @else
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    Draft
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($submission->status === 'graded')
                                <div class="text-sm font-medium text-gray-900">
                                    {{ $submission->score }} / {{ $assignment->total_points }}
                                </div>
                                <div class="text-xs text-gray-500">
                                    {{ number_format(($submission->score / $assignment->total_points) * 100, 1) }}%
                                </div>
                            @else
                                <span class="text-sm text-gray-500">Not graded</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="{{ Storage::url($submission->file_path) }}" target="_blank"
                                class="text-blue-600 hover:text-blue-900 mr-3">
                                <i class="fas fa-eye mr-1"></i>
                                View
                            </a>
                            @if($submission->status !== 'graded')
                                <button wire:click="openGradeModal('{{ $submission->id }}')"
                                    class="text-green-600 hover:text-green-900">
                                    <i class="fas fa-check mr-1"></i>
                                    Grade
                                </button>
                            @else
                                <button wire:click="openGradeModal('{{ $submission->id }}')"
                                    class="text-amber-600 hover:text-amber-900">
                                    <i class="fas fa-edit mr-1"></i>
                                    Edit Grade
                                </button>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <div class="text-gray-400">
                                <i class="fas fa-inbox text-4xl mb-3"></i>
                                <p class="text-gray-500">No submissions yet</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Grading Modal --}}
    @if($showGradeModal && $selectedSubmission)
        <div class="fixed inset-0 z-[9999] flex items-center justify-center bg-gray-500 bg-opacity-75"
            aria-labelledby="modal-title" role="dialog" aria-modal="true" wire:click.self="closeGradeModal">
            <!-- Modal panel -->
            <div
                class="bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all w-full max-w-lg mx-4">
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-semibold text-white flex items-center">
                            <i class="fas fa-star mr-2"></i>
                            Grade Submission
                        </h3>
                        <button wire:click="closeGradeModal" class="text-white hover:text-gray-200">
                            <i class="fas fa-times text-xl"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="px-6 py-4 max-h-[80vh] overflow-y-auto">
                    {{-- Student Info --}}
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <div class="h-12 w-12 rounded-full bg-blue-100 flex items-center justify-center">
                                <span class="text-blue-600 font-medium">
                                    {{ substr(strtoupper(string: $selectedSubmission->student->detail?->full_name), 0, 2) }}
                                </span>
                            </div>
                            <div class="ml-4">
                                <p class="font-semibold text-gray-800">
                                    {{ $selectedSubmission->detail?->full_name }}
                                </p>
                                <p class="text-sm text-gray-500">{{ $selectedSubmission->student->email }}</p>
                            </div>
                        </div>
                        <div class="mt-3 text-sm text-gray-600">
                            <p>Submitted:
                                {{ $submissionDate }}
                            </p>
                        </div>
                    </div>

                    {{-- Score Input --}}
                    <div class="mb-6">
                        <label for="score" class="block text-sm font-medium text-gray-700 mb-2">
                            Score <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="tel" wire:model.live="score" id="score" min="0" max="{{ $maxScore }}" step="1"
                                class="w-full rounded-lg border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 @error('score') border-red-500 @enderror"
                                placeholder="Enter score">
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <span class="text-gray-500 text-sm">/ {{ $maxScore }}</span>
                            </div>
                        </div>
                        @error('score')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @if($score)
                            <p class="mt-1 text-sm text-gray-600">
                                Percentage: <span class="font-medium">{{ number_format(($score / $maxScore) * 100, 1) }}%</span>
                            </p>
                        @endif
                    </div>

                    {{-- View Submission Link --}}
                    <div class="mb-4">
                        <a href="{{ Storage::url($selectedSubmission->file_path) }}" target="_blank"
                            class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800">
                            <i class="fas fa-external-link-alt mr-2"></i>
                            View submitted file
                        </a>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="bg-gray-50 px-6 py-4 flex items-center justify-end space-x-3">
                    <button wire:click="closeGradeModal" type="button"
                        class="px-4 py-2 bg-white border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium transition">
                        Cancel
                    </button>
                    <button wire:click="saveGrade" type="button"
                        class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium transition flex items-center">
                        <i class="fas fa-save mr-2"></i>
                        Save Grade
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>