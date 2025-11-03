<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\CourseContent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    /**
     * Get current user data from session.
     */
    private function getCurrentUser()
    {
        return [
            'name' => session('user_name'),
            'role' => 'Administrator',
            'initials' => substr(session('user_name'), 0, 2)
        ];
    }

    /**
     * Check if user is admin.
     */
    private function checkAdminAccess()
    {
        if (session('user_role') !== 'admin') {
            return redirect()->route('login')->with('error', 'Access denied. Admin privileges required.');
        }
        return null;
    }
    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
        // if ($redirect = $this->checkAdminAccess()) {
        //     return $redirect;
        // }
        // Get statistics
        $stats = [
            'admin_count' => User::role('admin')->count(),
            'student_count' => User::role('student')->count(),
            'instructor_count' => User::role('instructor')->count(),
            'total_courses' => Course::where('status', 'approved')->count(),
            'total_materials' => CourseContent::where('status', 'published')->count(),
            'assignment_count' => Assignment::where('status', 'published')->count()
        ];

        // Get recent enrollments
        $recentEnrollments = Enrollment::with(['user', 'course', 'course.instructor'])
            ->latest('enrolled_at')
            ->limit(5)
            ->get();

        // Get top performing courses
        $topPerformingCourses = Course::with('instructor')
            ->where('status', 'approved')
            ->orderBy('enrollment_count', 'desc')
            ->limit(5)
            ->get();

        // Get weekly enrollment data for chart (simplified for SQLite)
        $weeklyEnrollments = $this->fetchEnrollmentData();

        $enrollmentData = [
            'labels' => ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
            'data' => $weeklyEnrollments // Simplified for now
        ];

        return view('admin.dashboard', compact('stats', 'recentEnrollments', 'topPerformingCourses', 'enrollmentData'));
    }

    private function fetchEnrollmentData()
    {
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::SUNDAY);
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::SATURDAY);

        // Fetch enrollments grouped by day of week
        $enrollments = Enrollment::whereBetween('created_at', [$startOfWeek, $endOfWeek])
            ->select(
                DB::raw('DAYOFWEEK(created_at) as day_of_week'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('day_of_week')
            ->pluck('count', 'day_of_week');

        // Initialize data array with zeros for all days
        $data = [0, 0, 0, 0, 0, 0, 0];

        // Map the database results to the correct array positions
        // DAYOFWEEK returns 1=Sunday, 2=Monday, ..., 7=Saturday
        foreach ($enrollments as $dayOfWeek => $count) {
            $data[$dayOfWeek - 1] = $count;
        }

        return $data;
    }

    /**
     * Display a listing of instructors.
     */
    public function instructors()
    {
        // if ($redirect = $this->checkAdminAccess()) {
        //     return $redirect;
        // }

        return view('admin.instructors.index');
    }

    /**
     * Show the form for creating a new instructor.
     */
    public function createInstructor()
    {
        return view('admin.instructors.create');
    }

    /**
     * Store a newly created instructor.
     */
    public function storeInstructor(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'address' => 'required|string|max:500',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'instructor';

        User::create($validated);

        return redirect()->route('admin.instructors')->with('success', 'Instructor created successfully.');
    }

    /**
     * Display the specified instructor.
     */
    public function showInstructor(User $instructor)
    {
        $instructor->load('taughtCourses');
        return view('admin.instructors.show', compact('instructor'));
    }

    /**
     * Show the form for editing the specified instructor.
     */
    public function editInstructor(User $instructor)
    {
        return view('admin.instructors.edit', compact('instructor'));
    }

    /**
     * Update the specified instructor.
     */
    public function updateInstructor(Request $request, User $instructor)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($instructor->id)],
            'address' => 'required|string|max:500',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $instructor->update($validated);

        return redirect()->route('admin.instructors')->with('success', 'Instructor updated successfully.');
    }

    /**
     * Remove the specified instructor.
     */
    public function destroyInstructor(User $instructor)
    {
        $instructor->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Display a listing of students.
     */
    public function students()
    {
        return view('admin.students.index');
    }

    /**
     * Show the form for creating a new student.
     */
    public function createStudent()
    {
        return view('admin.students.create');
    }

    /**
     * Store a newly created student.
     */
    public function storeStudent(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'address' => 'required|string|max:500',
            'status' => 'required|in:pending,approved,rejected',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'student';

        User::create($validated);

        return redirect()->route('admin.students')->with('success', 'Student created successfully.');
    }

    /**
     * Display the specified student.
     */
    public function showStudent(User $student)
    {
        $student->load('courses');

        return view('admin.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function editStudent(User $student)
    {
        return view('admin.students.edit', compact('student'));
    }

    /**
     * Update the specified student.
     */
    public function updateStudent(Request $request, User $student)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($student->id)],
            'address' => 'required|string|max:500',
            'status' => 'required|in:pending,approved,rejected',
        ]);


        DB::beginTransaction();
        try {
            $student->update([
                'email' => $validated['email']
            ]);

            $student->detail()->update([
                'full_name' => $validated['name'],
                'address' => $validated['address'],
                'status' => $validated['status']
            ]);

            DB::commit();
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollback();
            Log::error('Something went wrong with updating a user. ' . $th->getMessage());
            abort(500);
        }

        return redirect()->route('admin.students')->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified student.
     */
    public function destroyStudent(User $student)
    {
        $student->delete();
        return response()->json(['success' => true]);
    }

    /**
     * Display a listing of courses.
     */
    public function courses()
    {
        // if ($redirect = $this->checkAdminAccess()) {
        //     return $redirect;
        // }

        $courses = Course::with('instructor')
            ->withCount('enrollments')
            ->get();

        return view('admin.courses.index', compact('courses'));
    }

    /**
     * Display the specified course.
     */
    public function showCourse(Course $course)
    {
        $course->load(['instructor', 'contents', 'enrollments.student']);
        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified course.
     */
    public function editCourse(Course $course)
    {
        return view('admin.courses.edit', compact('course'));
    }

    /**
     * Update the specified course.
     */
    public function updateCourse(Request $request, Course $course)
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

    /**
     * Remove the specified course.
     */
    public function destroyCourse(Course $course)
    {
        $course->delete();
        return response()->json(['success' => true]);
    }
}
