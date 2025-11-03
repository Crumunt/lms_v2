<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseContent;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class InstructorController extends Controller
{
    use AuthorizesRequests;

    public function index()
    {
        $user = Auth::user();
        $instructorId = $user->id; // or instructor id

        $latestEnrollments = User::whereHas('courses', function ($q) use ($instructorId) {
            $q->where('instructor_id', $instructorId);
        })
            ->with([
                'courses' => function ($q) use ($instructorId) {
                    $q->where('instructor_id', $instructorId)
                        ->orderByPivot('created_at', 'desc') // latest enrollments
                        ->withPivot('created_at');
                }
            ])
            ->take(5)
            ->get();

        $activeCourses = $user->taughtCourses()->approved()->count();

        $totalStudents = User::whereHas('courses', function ($q) use ($instructorId) {
            $q->where('instructor_id', $instructorId);
        })->count();

        $pendingGrading = Assignment::whereHas('course', function ($q) use ($instructorId) {
            $q->where('instructor_id', $instructorId);
        })
            ->withCount([
                'submissions as ungraded_count' => function ($q) {
                    $q->where('status', 'submitted');
                }
            ])
            ->having('ungraded_count', '>', 0)
            ->with('course:id,title,code')
            ->orderBy('ungraded_count', 'desc')
            ->count();

        $assignments = Assignment::whereHas('course', function($q) use ($instructorId) {
            $q->where('instructor_id', $instructorId);
        })
        ->where('status', 'published')
        ->where('due_date', '>', now())
        ->orderBy('due_date', 'desc')
        ->get();

        $stats = [
            [
                'icon' => 'fas fa-book-open',
                'iconBg' => 'bg-gradient-to-br from-blue-400 to-blue-600',
                'value' => $activeCourses,
                'label' => 'Active Courses',
                'trend' => 'up',
                'description' => 'This semester'
            ],
            [
                'icon' => 'fas fa-users',
                'iconBg' => 'bg-gradient-to-br from-green-400 to-green-600',
                'value' => $totalStudents,
                'label' => 'Total Students',
                'trend' => 'up',
                'description' => 'Across all courses'
            ],
            [
                'icon' => 'fas fa-tasks',
                'iconBg' => 'bg-gradient-to-br from-purple-400 to-purple-600',
                'value' => $pendingGrading,
                'label' => 'Pending Grading',
                'trend' => 'down',
                'description' => 'Assignments to review'
            ],
        ];

        return view('instructor.dashboard', compact('stats', 'assignments', 'latestEnrollments'));

    }

    public function students()
    {
        return view('instructor.students');
    }

    public function grades()
    {
        return view('instructor.grades');
    }

    public function analytics()
    {
        $user = [
            'name' => 'Dr. Lorenz',
            'department' => 'Computer Science',
            'initials' => 'JS'
        ];

        $notifications = ['assignments' => 8, 'students' => 3];

        return view('instructor.analytics', compact('user', 'notifications'));
    }

    public function discussions()
    {
        $user = [
            'name' => 'Dr. Lorenz',
            'department' => 'Computer Science',
            'initials' => 'JS'
        ];

        $notifications = ['assignments' => 8, 'students' => 3];

        return view('instructor.discussions', compact('user', 'notifications'));
    }

    public function resources()
    {
        $user = [
            'name' => 'Dr. Lorenz',
            'department' => 'Computer Science',
            'initials' => 'JS'
        ];

        $notifications = ['assignments' => 8, 'students' => 3];

        return view('instructor.resources', compact('user', 'notifications'));
    }

    public function schedule()
    {
        $user = [
            'name' => 'Dr. Lorenz',
            'department' => 'Computer Science',
            'initials' => 'JS'
        ];

        $notifications = ['assignments' => 8, 'students' => 3];

        return view('instructor.placeholder', compact('user', 'notifications'))->with([
            'title' => 'Schedule',
            'icon' => 'fas fa-calendar-alt',
            'description' => 'Manage your class schedule and office hours'
        ]);
    }

    public function showStudent($id)
    {
        $user = [
            'name' => 'Dr. Lorenz',
            'department' => 'Computer Science',
            'initials' => 'JS'
        ];

        $notifications = ['assignments' => 8, 'students' => 3];

        return view('instructor.placeholder', compact('user', 'notifications'))->with([
            'title' => 'Student Details',
            'icon' => 'fas fa-user',
            'description' => 'View student information and progress'
        ]);
    }

    public function settings()
    {
        $user = [
            'name' => 'Dr. Lorenz',
            'department' => 'Computer Science',
            'initials' => 'JS'
        ];

        $notifications = ['assignments' => 8, 'students' => 3];

        return view('instructor.placeholder', compact('user', 'notifications'))->with([
            'title' => 'Settings',
            'icon' => 'fas fa-cog',
            'description' => 'Manage your account and preferences'
        ]);
    }

}
