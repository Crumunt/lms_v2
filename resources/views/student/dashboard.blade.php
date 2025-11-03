@extends('layouts.student')

@section('content')
    <!-- Welcome Section -->
    <x-student.sections.welcome-card :user="$user" message="" :showContinueLearning="true" :showViewProgress="true" />

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @foreach($stats as $stat)
            <x-student.cards.stat-card :icon="$stat['icon']" :iconBg="$stat['iconBg']" :value="$stat['value']"
                :label="$stat['label']" :progress="$stat['progress']" />
        @endforeach
    </div>

    <!-- Enrolled Courses Section -->
    

    <!-- Recent Activities & Upcoming Events -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
        <!-- Recent Activities -->
        <x-student.sections.recent-activities :activities="$activities" />

        <!-- Upcoming Events -->
        <x-student.sections.upcoming-events :assignments="$assignments" />
    </div>
@endsection