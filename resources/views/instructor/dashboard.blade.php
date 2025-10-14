@extends('layouts.instructor')

@section('content')
    <x-instructor.sections.welcome-card :user="$user" message="You have 3 assignments to grade and 2 upcoming classes."
        :showCreateCourse="true" :showViewAnalytics="true" />

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @foreach($stats as $stat)
            <x-instructor.cards.stat-card :icon="$stat['icon']" :iconBg="$stat['iconBg']" :value="$stat['value']"
                :label="$stat['label']" :progress="$stat['progress']" :trend="$stat['trend']" :trendValue="$stat['trendValue']"
                :description="$stat['description']" />
        @endforeach
    </div>

    <!-- My Courses Section -->
    <section class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-chalkboard-teacher mr-3 text-green-600"></i>
                My Courses
            </h2>
            <button class="btn-primary">
                <i class="fas fa-plus mr-2"></i>
                Create New Course
            </button>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($courses as $course)
                <x-instructor.cards.course-card :course="$course" />
            @endforeach
        </div>
    </section>

    <!-- Pending Assignments & Recent Students -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Pending Assignments -->
        <x-instructor.sections.pending-assignments :assignments="$assignments" />

        <!-- Recent Students -->
        <x-instructor.sections.recent-students :students="$students" />
    </div>

    <!-- Quick Actions -->
    <x-instructor.sections.quick-actions />
@endsection