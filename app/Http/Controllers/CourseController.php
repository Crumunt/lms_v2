<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\CourseContent;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    use AuthorizesRequests;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        // Get courses from database
        $allCourses = Course::withCount(['assignments', 'enrollments'])->where('instructor_id', $user->id)->get();

        return view('instructor.courses', compact('allCourses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Course::class);

        return view('instructor.course.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        //
        $this->authorize('create', Course::class);

        $instructor_id = Auth::id();

        $validated = $request->validated();

        try {
            Course::create([
                'title' => $validated['title'],
                'code' => $validated['code'],
                'description' => $request->input('description'),
                'instructor_id' => $instructor_id,
                'status' => $validated['status'],
                'difficulty' => $validated['difficulty']
            ]);
        } catch (\Throwable $th) {
            Log::error('Course creation failed: ' . $th->getMessage());
            return back()->with('error', 'Something went wrong while saving the course.');
        }

        return redirect()->route('instructor.courses.index')->with('success', 'Course Created Successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        
        $user = Auth::user();
        
        $notifications = ['assignments' => 8, 'students' => 3];
        
        // Get course from database
        $course = Course::withCount(['assignments', 'enrollments'])->find($id);
        
        if (!$course) {
            abort(404);
        }

        $this->authorize('view', $course);

        return view('instructor.course.show', compact('course'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        
        $user = Auth::user();
        
        // Get course from database
        $course = Course::findOrFail($id);
        
        if (!$course) {
            abort(404);
        }

        $this->authorize('update', $course);

        // Convert to the format expected by the view
        $courseData = [
            'id' => $course->id,
            'title' => $course->title,
            'code' => $course->code,
            'description' => $course->description,
            'difficulty' => $course->difficulty,
            'status' => $course->status,
        ];

        return view('instructor.course.edit', compact('courseData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseRequest $request, Course $course)
    {
        //
        $this->authorize('update', $course);

        $validated = $request->validated();
        $updateData = collect($validated)->only(['title', 'code', 'difficulty', 'status'])->toArray();
        $updateData['description'] = $request->input('description');

        $course->update($updateData);

        return redirect()->route('instructor.courses.show', $course)
            ->with('success', 'Course updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        //
        $this->authorize('delete', $course);

        if ($course->instructor_id !== Auth::id()) {
            abort(403, 'You are not authorized to delete this course.');
        }

        try {
            $course->delete();
        } catch (\Throwable $th) {
            Log::error('Course deletion failed: ' . $th->getMessage());
            return back()->with('error', 'Something went wrong while deleting the course.');
        }

        return redirect()->route('instructor.courses.index')
            ->with('success', 'Course deleted successfully!');
    }
}
