<?php

namespace App\Http\Controllers\Course;

use App\Http\Controllers\Controller;
use App\Http\Requests\AssignmentRequest;
use App\Models\Assignment;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class AssignmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Course $course)
    {
        // Load assignments with submission counts
        $assignments = $course->assignments()
            ->withSubmissionCount()
            ->latest()
            ->get();

        // Calculate assignment statistics
        $assignmentData = [
            'total_count' => $assignments->count(),
            'published' => $assignments->where('status', 'published')->count(), // Fixed: was missing ->count()
            'draft' => $assignments->where('status', 'draft')->count(), // Fixed: was missing ->count()
            'pending_submissions' => $assignments->sum('pending_submissions_count'),
        ];

        return view('instructor.course.assignments.index', compact('course', 'assignmentData', 'assignments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Course $course)
    {
        //
        return view('instructor.course.assignments.create', compact('course'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(AssignmentRequest $request, Course $course)
    {
        //
        $validated = $request->validated();
        $validated['course_id'] = $course->id;

        try {
            Assignment::create($validated);
        } catch (\Throwable $th) {
            Log::error('Something went wrong ' . $th->getMessage());
        }

        return redirect()->route('instructor.courses.assignments.index', ['course' => $course])->with('message', 'success');
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course, Assignment $assignment)
    {
        //
        $submissions = $assignment->submissions()->paginate(15);
        $submissionStats = (object) [
            'submitted' => $assignment->submissions()->submitted()->count(), // Waiting to be graded
            'graded' => $assignment->submissions()->graded()->count(),       // Already graded
            'late' => $assignment->submissions()->late()->count(),           // Late submissions (any status)
            'pending' => $assignment->submissions()->pendingGrading()->count(), // Students who haven't submitted yet
        ];

        return view('instructor.course.assignments.show', compact('course', 'assignment', 'submissions', 'submissionStats'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course, Assignment $assignment)
    {
        //
        if ($course->id !== $assignment->course_id) {
            abort(403);
        }

        return view('instructor.course.assignments.edit', compact('course', 'assignment'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(AssignmentRequest $request, Course $course, Assignment $assignment)
    {
        //
        $validated = $request->validated();
        
        try {
            $assignment->update($validated);
        } catch (\Throwable $th) {
            Log::error('Someting went wrong.' . $th->getMessage());
            abort(500);
        }

        return redirect()->route('instructor.courses.assignments.index', $course)->with('message', 'update successful.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course, Assignment $assignment)
    {
        //

        if($course->instructor_id !== Auth::id()) {
            abort(403, 'You are not authorized to delete this object');
        }

        if($assignment->course_id !== $course->id) {
            abort(403, 'Invalid object for course');
        }

        try {
            $assignment->delete();
        } catch (\Throwable $th) {
            Log::error('Something went wrong with assignment deletion ' . $th->getMessage());
            abort(500);
        }

        return redirect()->route('instructor.courses.assignments.index', $course)->with('message', 'assignment sucecssfully deleted');
    }
}
