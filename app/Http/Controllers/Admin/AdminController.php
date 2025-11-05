<?php

namespace App\Http\Controllers\Admin;

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
use App\Http\Controllers\Controller;


class AdminController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function dashboard()
    {
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
}
