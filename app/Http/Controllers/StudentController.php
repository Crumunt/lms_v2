<?php

namespace App\Http\Controllers;

use App\Helpers\AssignmentHelper;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\CourseContent;
use App\Http\Controllers\EnrollmentController;
use App\Http\Requests\AssignmentRequest;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Services\EnrollmentService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Spatie\Activitylog\Models\Activity;

class StudentController extends Controller
{
    protected $enrollmentService;

    public function __construct(EnrollmentService $enrollmentService)
    {
        $this->enrollmentService = $enrollmentService;
    }

    public function index()
    {
        $user = Auth::user();

        $enrolledCourses = $user->courses->count();

        // ! TO BE FILLED
        $activities = Activity::causedBy($user)->latest()->get();
        $student_id = $user->id;
        $assignments = $user->enrolledAssignments()->where('status', 'published')->latest()->get();

        $stats = [
            [
                'icon' => 'fas fa-book',
                'iconBg' => 'bg-gradient-to-br from-blue-400 to-blue-600',
                'value' => $enrolledCourses,
                'label' => 'Enrolled Courses',
                'progress' => 75
            ],
            [
                'icon' => 'fas fa-check-circle',
                'iconBg' => 'bg-gradient-to-br from-green-400 to-green-600',
                'value' => 0,
                'label' => 'Completed Courses',
                'progress' => 85
            ],
            [
                'icon' => 'fas fa-trophy',
                'iconBg' => 'bg-gradient-to-br from-purple-400 to-purple-600',
                'value' => 0,
                'label' => 'Average Grade',
                'progress' => 92
            ],
            [
                'icon' => 'fas fa-clock',
                'iconBg' => 'bg-gradient-to-br from-orange-400 to-orange-600',
                'value' => '0h',
                'label' => 'Study Time',
                'progress' => 60
            ]
        ];

        return view('student.dashboard', compact('user', 'activities', 'assignments', 'stats'));
    }

    public function courses1()
    {
        $user = Auth::user();
        $enrolledCourses = $user->courses()->with('instructor')->withTimestamps()->get();

        return view('student.courses', compact('enrolledCourses'));
    }

    public function showCourse($id)
    {
        // GET AUTHENTICATED USER
        $user = Auth::user();

        // GET ENROLLED COURSE
        $enrolledCourse = $user->courses()->with('instructor')->find($id);
        // CHECK IF IT COURSE ENROLLMENT EXISTS
        if (!$enrolledCourse) {
            return redirect()->route('student.catalog')->with('error', 'You are not enrolled in this course.');
        }

        // FETCH ALL ASSIGNMENTS AND ADD FLAG IF SUBMITTED OR NAH
        $assignments = $enrolledCourse->assignments()
            ->where('status', 'published')
            ->withExists([
                'submissions as is_submitted' => function ($q) use ($user) {
                    $q->where('student_id', $user->id);
                }
            ])
            ->orderByDesc('created_at')
            ->get();

        $assignments = $this->transformAssignments($assignments);

        // Get course content
        $course_content = $enrolledCourse->contents->where('status', 'published');

        return view('student.course.show', compact('course_content', 'enrolledCourse', 'assignments'));
    }

    private function transformAssignments($assignments)
    {
        return $assignments->map(function ($assignment) {
            $styling = AssignmentHelper::getAssignmentStyling($assignment->is_submitted, $assignment->due_date);

            $assignment->status_badge = $styling['status'];
            $assignment->icon_color = $styling['icon_color'];
            $assignment->border_color = $styling['border_color'];
            $assignment->hover_color = $styling['hover_color'];
            $assignment->formatted_due_date = AssignmentHelper::formatDueDate($assignment->due_date);
            $assignment->is_urgent = AssignmentHelper::isUrgent($assignment->due_date);

            return $assignment;
        });
    }

    public function catalog()
    {
        return view('student.catalog');
    }

    public function showAssignment(Course $course, Assignment $assignment)
    {
        $user = Auth::user();
        $assignment = Assignment::where('id', $assignment->id)
            ->where('course_id', $course->id)
            ->withExists([
                'submissions as is_submitted' => function ($q) use ($user) {
                    $q->where('student_id', $user->id);
                }
            ])
            ->firstOrFail();

        $styling = AssignmentHelper::getAssignmentStyling($assignment->is_submitted, $assignment->due_date);
        $assignment->status_badge = $styling['status'];
        $assignment->icon_color = $styling['icon_color'];
        $assignment->border_color = $styling['border_color'];
        $assignment->hover_color = $styling['hover_color'];
        $assignment->formatted_due_date = AssignmentHelper::formatDueDate($assignment->due_date);
        $assignment->is_urgent = AssignmentHelper::isUrgent($assignment->due_date);

        $submission = $assignment->submissions()?->first() ?? null;
        
        return view('student.course.assignment.show', compact('course', 'assignment', 'submission'));
    }

    public function submitAssignment(Request $request, Course $course, Assignment $assignment)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'file' => ['required', 'file', 'mimes:pdf', 'max:10240']
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            // Generate unique filename
            $fileName = time() . '_' . $file->hashName();

            // Store file in storage/app/public/course-contents
            $filePath = $file->storeAs('assignment-uploads', $fileName, 'public');

            // Add file information to validated data
            $validated['file_path'] = $filePath;
        }

        $validated['assignment_id'] = $assignment->id;
        $validated['student_id'] = $user->id;
        $validated['submitted_at'] = now();

        try {
            $assignment = AssignmentSubmission::create($validated);

            activity('assignment submission')
            ->performedOn($assignment)
            ->withProperties([
                'course_id' => $course->id,
                'course_title' => $course->title,
                'course_code' => $course->code,
                'assignment_id' => $assignment->id,
                'assignment_title' => $assignment->title
            ])
            ->log('Student has submitted assignment.');
        } catch (\Throwable $th) {
            Log::error('Something went wrong with assignment submission ' . $th->getMessage());
            abort(500);
        }

        return redirect()->back()->with('message', 'Assignment has been successfully turned in.');
    }
}
