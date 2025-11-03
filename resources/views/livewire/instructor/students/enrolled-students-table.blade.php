@props(['enrolledStudents'])
<div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Course
                    </th>
                    <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status
                    </th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @forelse($enrolledStudents as $enrolledStudent)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800">
                            {{ $enrolledStudent->user?->detail?->full_name }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">{{ $enrolledStudent->user?->email }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">{{ $enrolledStudent->course?->title }}
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span
                                class="text-xs px-2 py-1 rounded-full {{ strtolower($enrolledStudent->user?->detail?->status->value) === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">{{ $enrolledStudent->user?->detail?->status->value }}</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500 text-sm">No students found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>