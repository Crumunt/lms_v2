@extends('layouts.instructor')

@section('content')
    <x-instructor.sections.welcome-card :user="$user" message="You have 3 assignments to grade and 2 upcoming classes."
        :showCreateCourse="true" :showViewAnalytics="true" />

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @foreach($stats as $stat)
            <x-instructor.cards.stat-card :icon="$stat['icon']" :iconBg="$stat['iconBg']" :value="$stat['value']"
                :label="$stat['label']" :trend="$stat['trend']" :trendValue="$stat['trendValue']"
                :description="$stat['description']" />
        @endforeach
    </div>


    <!-- Pending Assignments & Recent Students -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Pending Assignments -->
        <x-instructor.sections.pending-assignments :assignments="$assignments" />

        <!-- Recent Students -->
        <x-instructor.sections.recent-students :students="$latestEnrollments" />
    </div>

    <!-- Quick Actions -->
    <x-instructor.sections.quick-actions />
@endsection