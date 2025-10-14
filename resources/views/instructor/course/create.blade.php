@props(['user' => ['name' => 'Dr. Lorenz', 'department' => 'Computer Science', 'initials' => 'JS']])

@extends('layouts.instructor')
@section('content')

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-3xl font-bold text-gray-800">Create Course</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-lg border border-gray-100 p-6">
        <form method="POST" action="{{ route('instructor.course.store') }}" class="space-y-6">
            @csrf
            @php
                $propsId = ["name" => "id", "label" => "Course ID", "placeholder" => "cs701", "required" => true];
                $propsCode = ["name" => "code", "label" => "Course Code", "placeholder" => "CS 701 - 3 Units", "required" => true];
                $propsTitle = ["name" => "title", "label" => "Title", "placeholder" => "Advanced Algorithms", "required" => true];
                $propsIcon = ["name" => "icon", "label" => "Icon (Font Awesome class)", "placeholder" => "fas fa-microchip"];
                $statusOptions = [["label" => "Active", "value" => "active"], ["label" => "Draft", "value" => "draft"], ["label" => "Archived", "value" => "archived"]];
                $propsStatus = ["name" => "status", "label" => "Status", "options" => $statusOptions, "defaultValue" => $statusOptions[0], "sx" => ["width" => "100%"]];
                $propsNextClass = ["name" => "nextClass", "label" => "Next Class", "placeholder" => "Monday, 10:00 AM"];
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div data-react-component="TextInput" data-props='@json($propsId)'></div>
                <div data-react-component="TextInput" data-props='@json($propsCode)'></div>
                <div data-react-component="TextInput" data-props='@json($propsTitle)'></div>
                <div data-react-component="TextInput" data-props='@json($propsIcon)'></div>
                <div data-react-component="SelectAutocomplete" data-props='@json($propsStatus)'></div>
                <div data-react-component="TextInput" data-props='@json($propsNextClass)'></div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="5" class="w-full border border-gray-300 rounded-lg p-3"
                    placeholder="Course description..." required></textarea>
            </div>
            <div class="flex items-center space-x-3">
                <button class="btn-primary" type="submit">
                    <i class="fas fa-save mr-2"></i>Save Course
                </button>
                <a href="{{ route('instructor.courses') }}" class="btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection