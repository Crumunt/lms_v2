<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\CourseContent;
use App\Http\Controllers\EnrollmentController;
use App\Services\EnrollmentService;
use Illuminate\Support\Facades\Auth;

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
        $activities = [];
        $events = [];

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

        return view('student.dashboard', compact('user', 'activities', 'events', 'stats'));
    }

    public function courses1()
    {
        $user = Auth::user();

        $courses = [
            [
                'id' => 'cs101',
                'title' => 'Introduction to Programming',
                'code' => 'CS 101',
                'description' => 'Learn the fundamentals of computer programming with Python and JavaScript.',
                'progress' => 78,
                'students' => 45,
                'icon' => 'fas fa-code'
            ],
            [
                'id' => 'cs201',
                'title' => 'Database Management',
                'code' => 'CS 201',
                'description' => 'Master SQL and database design principles for modern applications.',
                'progress' => 65,
                'students' => 38,
                'icon' => 'fas fa-database'
            ],
            [
                'id' => 'cs301',
                'title' => 'Computer Networks',
                'code' => 'CS 301',
                'description' => 'Understanding network protocols, security, and infrastructure.',
                'progress' => 42,
                'students' => 52,
                'icon' => 'fas fa-network-wired'
            ],
            [
                'id' => 'cs401',
                'title' => 'Mobile App Development',
                'code' => 'CS 401',
                'description' => 'Build cross-platform mobile applications using React Native.',
                'progress' => 90,
                'students' => 29,
                'icon' => 'fas fa-mobile-alt'
            ],
            [
                'id' => 'cs501',
                'title' => 'Cybersecurity Fundamentals',
                'code' => 'CS 501',
                'description' => 'Learn about network security, encryption, and ethical hacking.',
                'progress' => 35,
                'students' => 41,
                'icon' => 'fas fa-shield-alt'
            ],
            [
                'id' => 'cs601',
                'title' => 'Artificial Intelligence',
                'code' => 'CS 601',
                'description' => 'Introduction to machine learning, neural networks, and AI algorithms.',
                'progress' => 28,
                'students' => 33,
                'icon' => 'fas fa-brain'
            ]
        ];

        $notifications = ['courses' => 5, 'assignments' => 2];

        $enrolledCourses = $user->courses()->with('instructor')->withTimestamps()->get();

        return view('student.courses', compact('user', 'notifications', 'enrolledCourses'));
    }

    public function showCourse($id)
    {
        // GET AUTHENTICATED USER
        $user = Auth::user();

        // TO BE ADDED
        $notifications = ['courses' => 5, 'assignments' => 2];

        // GET ENROLLED COURSE
        $enrolledCourse = $user->courses()->with('instructor')->find($id);
        // CHECK IF IT COURSE ENROLLMENT EXISTS
        if (!$enrolledCourse) {
            return redirect()->route('student.catalog')->with('error', 'You are not enrolled in this course.');
        }

        // Get course content
        $contentData = $enrolledCourse->contents->first();
        // dd($contentData);
        $courseData = [
            'id' => $enrolledCourse->id,
            'title' => $enrolledCourse->title,
            'code' => $enrolledCourse->code,
            'description' => $enrolledCourse->description,
            'instructor' => [
                'name' => $enrolledCourse->instructor?->detail?->full_name,
                'department' => 'Computer Science Department',
                'email' => $enrolledCourse->instructor?->email,
                'initials' => substr($enrolledCourse->instructor?->detail?->full_name, 0, 2)
            ],
            'enrolled' => true,
            'enrollmentDate' => $enrolledCourse->pivot->created_at->format('M j, Y'),
            'icon' => 'fas fa-book'
        ];

        return view('student.course.show', compact('user', 'notifications', 'courseData', 'contentData'));
    }

    public function enroll($course)
    {

        $user = Auth::user();

        dd($course);

        // if($this->enrollmentService->isUserEnrolled($user, ))

    }

    public function toggleEnrollment(Request $request, $id)
    {
        $enrolledIds = session('enrollments', []);
        $isUnenrolling = $request->has('unenroll');

        if ($isUnenrolling) {
            $enrolledIds = array_values(array_filter($enrolledIds, function ($courseId) use ($id) {
                return $courseId !== $id;
            }));
            session(['enrollments' => $enrolledIds]);
            return redirect()->back()->with('status', 'You have unenrolled from the course.');
        }

        if (!in_array($id, $enrolledIds, true)) {
            $enrolledIds[] = $id;
            session(['enrollments' => $enrolledIds]);
        }

        return redirect()->back()->with('status', 'You have enrolled in the course.');
    }

    public function catalog()
    {
        $user = Auth::user();

        $notifications = ['courses' => 5, 'assignments' => 2];

        // Get available courses from database
        $enrolledCourses = $user->courses()->pluck('courses.id');
        $availableCourses = Course::whereNotIn('id', $enrolledCourses)->with('instructor')->get();

        return view('student.catalog', compact('user', 'notifications'));
    }
}
