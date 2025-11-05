<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;

class AdminCourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('instructor')
            ->withCount('enrollments')
            ->get();

        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Display the specified course.
     */
    public function show(Course $course)
    {
        $course->load(['instructor', 'contents', 'enrollments.student']);
        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified course.
     */
    public function edit(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    /**
     * Update the specified course.
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'code' => 'required|string|max:50',
            'description' => 'required|string|max:1000',
            'status' => 'required|in:pending,approved,rejected,active,inactive,archived,draft',
            'difficulty' => 'required|in:beginner,intermediate,advanced',
        ]);

        $course->update($validated);

        return redirect()->route('admin.courses')->with('success', 'Course updated successfully.');
    }
}
