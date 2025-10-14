@extends('layouts.instructor')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Students</h1>
            <p class="text-gray-600 mt-2">Manage your students across all courses</p>
        </div>
        <button class="btn-primary">
            <i class="fas fa-user-plus mr-2"></i>
            Add Student
        </button>
    </div>

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
                    @foreach(($students ?? []) as $student)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-800">{{ $student['name'] }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">{{ $student['email'] }}</td>
                            <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">{{ $student['course'] }}</td>
                            <td class="px-4 py-3 whitespace-nowrap">
                                <span
                                    class="text-xs px-2 py-1 rounded-full {{ strtolower($student['status']) === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">{{ $student['status'] }}</span>
                            </td>
                            <td class="px-4 py-3 whitespace-nowrap text-right">
                                <a href="{{ route('instructor.student.show', $student['id']) }}"
                                    class="text-purple-600 hover:text-purple-800 text-sm">View</a>
                            </td>
                        </tr>
                    @endforeach
                    @if(empty($students))
                        <tr>
                            <td colspan="5" class="px-4 py-6 text-center text-gray-500 text-sm">No students found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection