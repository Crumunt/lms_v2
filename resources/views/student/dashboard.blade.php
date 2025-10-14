@extends('layouts.student')

@section('content')
    <!-- Welcome Section -->
    <x-student.sections.welcome-card :user="$user" message="You have 3 assignments due this week and 2 upcoming quizzes."
        :showContinueLearning="true" :showViewProgress="true" />

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @foreach($stats as $stat)
            <x-student.cards.stat-card :icon="$stat['icon']" :iconBg="$stat['iconBg']" :value="$stat['value']"
                :label="$stat['label']" :progress="$stat['progress']" />
        @endforeach
    </div>

    <!-- Enrolled Courses Section -->
    <section class="mb-8">
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-2xl font-bold text-gray-800">
                <i class="fas fa-graduation-cap mr-3 text-green-600"></i>
                My Enrolled Courses
            </h2>
            <a class="btn-secondary" href="{{ route('student.catalog') }}">
                <i class="fas fa-plus mr-2"></i>
                Browse More Courses
            </a>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($courses as $course)
                <x-student.cards.course-card :course="$course" />
            @endforeach
        </div>
    </section>

    <!-- Recent Activities & Upcoming Events -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Recent Activities -->
        <x-student.sections.recent-activities :activities="$activities" />

        <!-- Upcoming Events -->
        <x-student.sections.upcoming-events :events="$events" />
    </div>
@endsection