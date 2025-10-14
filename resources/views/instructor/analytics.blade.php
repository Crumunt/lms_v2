@extends('layouts.instructor')

@section('content')
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-800">Analytics</h1>
            <p class="text-gray-600 mt-2">Track student performance and course analytics</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
        <div class="text-center py-12">
            <i class="fas fa-chart-bar text-6xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-medium text-gray-600 mb-2">Course Analytics</h3>
            <p class="text-gray-500">This page will show detailed analytics and reports</p>
        </div>
    </div>
@endsection