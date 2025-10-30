<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\CourseContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = [
            'name' => 'Dr. Lorenz',
            'department' => 'Computer Science',
            'initials' => 'JS'
        ];

        $notifications = ['assignments' => 8, 'students' => 3];

        // Get courses from database
        $allCourses = Course::all()->map(function ($course) {
            return [
                'id' => $course->id,
                'title' => $course->title,
                'code' => $course->code,
                'description' => html_entity_decode($course->description),
                'instructor' => 'Dr. Lorenz', // Default instructor name
                'enrollment_count' => $course->enrollment_count,
                'difficulty' => $course->difficulty,
                'status' => $course->status,
                'created_at' => $course->created_at,
                'icon' => 'fas fa-book',
                'students' => $course->enrollment_count,
                'assignments' => 0
            ];
        });

        return view('instructor.courses', compact('user', 'notifications', 'allCourses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $user = Auth::user();

        $notifications = ['assignments' => 8, 'students' => 3];
        return view('instructor.course.create', compact('user', 'notifications'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        //
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
        $course = Course::find($id);

        if (!$course) {
            abort(404);
        }

        // Convert to the format expected by the view
        $courseData = [
            'id' => $course->id,
            'title' => $course->title,
            'code' => $course->code,
            'description' => $course->description,
            'instructor' => [
                'name' => 'Dr. Lorenz',
                'department' => 'Computer Science Department',
                'email' => 'dr.lorenz@clsu.edu.ph',
                'initials' => 'DL'
            ],
            'enrollment_count' => $course->enrollment_count,
            'difficulty' => $course->difficulty,
            'status' => $course->status,
            'assignments' => 8, // Default assignment count
            'students' => $course->enrollment_count // For compatibility
        ];

        $students = [
            ['id' => 1, 'name' => 'Francis', 'email' => 'john.doe@student.clsu.edu.ph', 'status' => 'Active', 'lastActivity' => '2h ago'],
            ['id' => 2, 'name' => 'Lorenz', 'email' => 'jane.smith@student.clsu.edu.ph', 'status' => 'Active', 'lastActivity' => '4h ago'],
            ['id' => 3, 'name' => 'Mike Johnson', 'email' => 'mike.johnson@student.clsu.edu.ph', 'status' => 'Inactive', 'lastActivity' => '1d ago'],
        ];

        // Get course contents from database
        $contents = CourseContent::where('course_id', $id)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($content) {
                return [
                    'id' => $content->id,
                    'title' => $content->title,
                    'description' => $content->description,
                    'status' => $content->status,
                    'file_path' => $content->file_path,
                    'uploaded_at' => $content->uploaded_at->format('M j, Y g:i A')
                ];
            });

        return view('instructor.course.show', compact('user', 'notifications', 'courseData', 'students', 'contents'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        $user = Auth::user();

        $notifications = ['assignments' => 8, 'students' => 3];

        // Get course from database
        $course = Course::findOrFail($id);

        if (!$course) {
            abort(404);
        }

        // Convert to the format expected by the view
        $courseData = [
            'id' => $course->id,
            'title' => $course->title,
            'code' => $course->code,
            'description' => $course->description,
            'difficulty' => $course->difficulty,
            'status' => $course->status,
        ];

        return view('instructor.course.edit', compact('user', 'notifications', 'courseData'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseRequest $request, Course $course)
    {
        //
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
