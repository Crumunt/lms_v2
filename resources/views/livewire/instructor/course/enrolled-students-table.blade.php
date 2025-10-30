@props(['students'])

<div class="overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name
                </th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email
                </th>
                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @foreach($students as $student)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800">{{ $student->detail?->full_name }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">{{ $student->email }}</td>
                    <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500"><a
                            href="{{ route('instructor.student.show', $student['id']) }}"
                            class="text-purple-600 hover:text-purple-800 text-sm">View</a>
                    </td>
                </tr>
            @endforeach
            @if(empty($students))
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-500 text-sm">No students enrolled yet.
                    </td>
                </tr>
            @endif

            <div class="mt-4">
                {{ $students->links() }} <!-- Livewire pagination links -->
            </div>
        </tbody>
    </table>
</div>