@props([
    'students' => [
        [
            'id' => 1,
            'name' => 'Francis',
            'email' => 'john.doe@student.clsu.edu.ph',
            'course' => 'CS 101',
            'lastActivity' => '2 hours ago',
            'status' => 'active',
            'avatar' => 'JD'
        ],
        [
            'id' => 2,
            'name' => 'Lorenz',
            'email' => 'jane.smith@student.clsu.edu.ph',
            'course' => 'CS 201',
            'lastActivity' => '4 hours ago',
            'status' => 'active',
            'avatar' => 'JS'
        ],
        [
            'id' => 3,
            'name' => 'Mike Johnson',
            'email' => 'mike.johnson@student.clsu.edu.ph',
            'course' => 'CS 301',
            'lastActivity' => '1 day ago',
            'status' => 'inactive',
            'avatar' => 'MJ'
        ],
        [
            'id' => 4,
            'name' => 'Sarah Wilson',
            'email' => 'sarah.wilson@student.clsu.edu.ph',
            'course' => 'CS 101',
            'lastActivity' => '3 hours ago',
            'status' => 'active',
            'avatar' => 'SW'
        ]
    ]
])

<section>
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-xl font-bold text-gray-800">
            <i class="fas fa-users mr-3 text-blue-600"></i>
            Recent Students
        </h2>
        <button class="text-sm text-purple-600 hover:text-purple-700 font-medium" onclick="window.location.href='{{ route('instructor.students') }}'">
            View All
        </button>
    </div>
    
    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 overflow-hidden">
    <div class="p-6">
        <div class="space-y-4">
            @forelse($students as $student)
                <div class="flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-50 transition">
                    <div class="w-12 h-12 rounded-full bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center text-white font-bold text-sm">
                        {{ $student['avatar'] }}
                    </div>
                    <div class="flex-1">
                        <div class="flex items-center justify-between">
                            <h3 class="text-sm font-medium text-gray-800">{{ $student['name'] }}</h3>
                            <span class="w-2 h-2 rounded-full {{ $student['status'] === 'active' ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                        </div>
                        <p class="text-xs text-gray-500 mb-1">{{ $student['email'] }}</p>
                        <div class="flex items-center justify-between">
                            <p class="text-xs text-gray-600">{{ $student['course'] }}</p>
                            <p class="text-xs text-gray-400">{{ $student['lastActivity'] }}</p>
                        </div>
                    </div>
                    <button class="text-gray-400 hover:text-gray-600 transition" 
                            onclick="window.location.href='{{ route('instructor.student.show', $student['id']) }}'">
                        <i class="fas fa-arrow-right"></i>
                    </button>
                </div>
            @empty
                <div class="p-6 text-center text-gray-500">
                    <i class="fas fa-user-graduate text-gray-400 text-lg mb-2"></i>
                    <p>No students found.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

</section>
