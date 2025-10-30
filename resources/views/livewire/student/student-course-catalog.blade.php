@props([
    'courses',
    'isEnroll' => true
])

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

    @forelse($courses as $course)
        <x-student.cards.course-card :course="$course" :isEnroll="$isEnroll"/>
    @empty
        <div class="col-span-3 text-center py-12">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-inbox text-4xl text-gray-400"></i>
            </div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">No available courses</h3>
            @if ($isEnroll)
                <p class="text-gray-600">You have already enrolled in all available courses.</p>
            @else
                <p class="text-gray-600">View the course catalog to enroll courses.</p>
            @endif
        </div>
    @endforelse
</div>