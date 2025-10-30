<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\CourseContent;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class InstructorController extends Controller
{
    private $courseData = [
        'cs101' => [
            'title' => 'Introduction to Programming',
            'code' => 'CS 101 - 3 Units',
            'icon' => 'fas fa-code',
            'description' => 'This course introduces students to the fundamental concepts of computer programming. Students will learn problem-solving techniques, algorithm design, and implementation using modern programming languages. The course covers variables, control structures, functions, arrays, and object-oriented programming principles.',
            'students' => 45,
            'assignments' => 8,
            'status' => 'active',
            'progress' => 75,
            'nextClass' => 'Tomorrow, 9:00 AM',
            'instructor' => 'Dr. Lorenz'
        ],
        'cs201' => [
            'title' => 'Database Management',
            'code' => 'CS 201 - 3 Units',
            'icon' => 'fas fa-database',
            'description' => 'Master SQL and database design principles for modern applications. Learn about relational database concepts, normalization, indexing, and query optimization.',
            'students' => 38,
            'assignments' => 6,
            'status' => 'active',
            'progress' => 65,
            'nextClass' => 'Wednesday, 2:00 PM',
            'instructor' => 'Dr. Lorenz'
        ],
        'cs301' => [
            'title' => 'Computer Networks',
            'code' => 'CS 301 - 3 Units',
            'icon' => 'fas fa-network-wired',
            'description' => 'Understanding network protocols, security, and infrastructure. Learn about TCP/IP, routing, switching, and network security fundamentals.',
            'students' => 52,
            'assignments' => 5,
            'status' => 'active',
            'progress' => 42,
            'nextClass' => 'Friday, 10:00 AM',
            'instructor' => 'Dr. Lorenz'
        ],
        'cs401' => [
            'title' => 'Mobile App Development',
            'code' => 'CS 401 - 3 Units',
            'icon' => 'fas fa-mobile-alt',
            'description' => 'Build cross-platform mobile applications using React Native. Learn about mobile UI/UX design, state management, and app deployment.',
            'students' => 29,
            'assignments' => 7,
            'status' => 'active',
            'progress' => 90,
            'nextClass' => 'Thursday, 1:00 PM',
            'instructor' => 'Dr. Lorenz'
        ],
        'cs501' => [
            'title' => 'Cybersecurity Fundamentals',
            'code' => 'CS 501 - 3 Units',
            'icon' => 'fas fa-shield-alt',
            'description' => 'Learn about network security, encryption, and ethical hacking. Understand security threats, vulnerabilities, and defense mechanisms.',
            'students' => 41,
            'assignments' => 4,
            'status' => 'active',
            'progress' => 35,
            'nextClass' => 'Monday, 3:00 PM',
            'instructor' => 'Dr. Lorenz'
        ],
        'cs601' => [
            'title' => 'Artificial Intelligence',
            'code' => 'CS 601 - 3 Units',
            'icon' => 'fas fa-brain',
            'description' => 'Introduction to machine learning, neural networks, and AI algorithms. Explore supervised and unsupervised learning techniques.',
            'students' => 33,
            'assignments' => 3,
            'status' => 'draft',
            'progress' => 28,
            'nextClass' => 'Tuesday, 11:00 AM',
            'instructor' => 'Dr. Lorenz'
        ]
    ];

    public function index()
    {
        $user = Auth::user();
        $instructorId = $user->id; // or instructor id

        $assignments = [];

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

        $stats = [
            [
                'icon' => 'fas fa-book-open',
                'iconBg' => 'bg-gradient-to-br from-blue-400 to-blue-600',
                'value' => $activeCourses,
                'label' => 'Active Courses',
                'trend' => 'up',
                'trendValue' => '+2',
                'description' => 'This semester'
            ],
            [
                'icon' => 'fas fa-users',
                'iconBg' => 'bg-gradient-to-br from-green-400 to-green-600',
                'value' => $totalStudents,
                'label' => 'Total Students',
                'trend' => 'up',
                'trendValue' => '+15',
                'description' => 'Across all courses'
            ],
            [
                'icon' => 'fas fa-tasks',
                'iconBg' => 'bg-gradient-to-br from-purple-400 to-purple-600',
                'value' => '23',
                'label' => 'Pending Grading',
                'trend' => 'down',
                'trendValue' => '-5',
                'description' => 'Assignments to review'
            ],
            [
                'icon' => 'fas fa-chart-line',
                'iconBg' => 'bg-gradient-to-br from-orange-400 to-orange-600',
                'value' => '4.8',
                'label' => 'Avg Rating',
                'trend' => 'up',
                'trendValue' => '+0.2',
                'description' => 'Student feedback'
            ]
        ];

        $notifications = ['assignments' => 8, 'students' => 3];

        return view('instructor.dashboard', compact('user', 'notifications', 'stats', 'assignments', 'latestEnrollments'));

    }

    public function courses()
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

        return view('instructor.courses.', compact('user', 'notifications', 'allCourses'));
    }



    public function students()
    {
        $user = Auth::user();

        $notifications = ['assignments' => 8, 'students' => 3];
        $students = [
            ['id' => 1, 'name' => 'Francis', 'email' => 'john.doe@student.clsu.edu.ph', 'course' => 'CS 101', 'status' => 'Active'],
            ['id' => 2, 'name' => 'Lorenz', 'email' => 'jane.smith@student.clsu.edu.ph', 'course' => 'CS 201', 'status' => 'Active'],
            ['id' => 3, 'name' => 'Mike Johnson', 'email' => 'mike.johnson@student.clsu.edu.ph', 'course' => 'CS 301', 'status' => 'Inactive'],
            ['id' => 4, 'name' => 'Sarah Wilson', 'email' => 'sarah.wilson@student.clsu.edu.ph', 'course' => 'CS 101', 'status' => 'Active'],
        ];

        $students = User::whereHas('courses', function ($query) use ($user) {
            $query->where('instructor_id', $user->id)->approved();
        })->get();
        return view('instructor.students', compact('user', 'notifications', 'students'));
    }

    public function assignments()
    {
        $user = [
            'name' => 'Dr. Lorenz',
            'department' => 'Computer Science',
            'initials' => 'JS'
        ];

        $notifications = ['assignments' => 8, 'students' => 3];

        return view('instructor.assignments', compact('user', 'notifications'));
    }

    public function grades()
    {
        $user = [
            'name' => 'Dr. Lorenz',
            'department' => 'Computer Science',
            'initials' => 'JS'
        ];

        $notifications = ['assignments' => 8, 'students' => 3];

        return view('instructor.grades', compact('user', 'notifications'));
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

    public function createCourse()
    {
        $user = [
            'name' => 'Dr. Lorenz',
            'department' => 'Computer Science',
            'initials' => 'JS'
        ];

        $notifications = ['assignments' => 8, 'students' => 3];
        return view('instructor.courses.create', compact('user', 'notifications'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $plainDescription = strip_tags($request->input('description'));

        // Replace multiple whitespace (spaces, newlines, tabs) with a single space
        $plainDescription = preg_replace('/\s+/u', ' ', $plainDescription);

        // Trim leading/trailing spaces
        $plainDescription = trim($plainDescription);
        $request->merge([
            'plain_description' => $plainDescription
        ]);

        $validated = $request->validate([
            'title' => ['required', 'unique:courses', 'max:100', 'string'],
            'code' => ['required', 'unique:courses', 'max:20', 'string'],
            'difficulty' => ['required', 'string'],
            'status' => ['required', 'string'],
            'plain_description' => ['required', 'max:255', 'string']
        ]);

        try {
            Course::create([
                'title' => $validated['title'],
                'code' => $validated['code'],
                'description' => $request->input('description'),
                'instructor_id' => $user->id,
                'status' => $validated['status'],
                'difficulty' => $validated['difficulty']
            ]);
        } catch (\Throwable $th) {

            dd($th);
            Log::error('Course creation failed: ' . $th->getMessage());
            return back()->with('error', 'Something went wrong while saving the course.');
        }

        return redirect()->route('instructor.courses.')->with('success', 'Course Created Successfully');
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

    public function showAssignment($id)
    {
        $user = [
            'name' => 'Dr. Lorenz',
            'department' => 'Computer Science',
            'initials' => 'JS'
        ];

        $notifications = ['assignments' => 8, 'students' => 3];

        return view('instructor.placeholder', compact('user', 'notifications'))->with([
            'title' => 'Assignment Details',
            'icon' => 'fas fa-tasks',
            'description' => 'View and grade assignment submissions'
        ]);
    }

    public function createAssignment()
    {
        $user = [
            'name' => 'Dr. Lorenz',
            'department' => 'Computer Science',
            'initials' => 'JS'
        ];

        $notifications = ['assignments' => 8, 'students' => 3];

        return view('instructor.placeholder', compact('user', 'notifications'))->with([
            'title' => 'Create Assignment',
            'icon' => 'fas fa-plus',
            'description' => 'Create a new assignment'
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


    public function storeCourse(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|string',
            'title' => 'required|string',
            'code' => 'required|string',
            'description' => 'required|string',
            'icon' => 'nullable|string',
            'students' => 'nullable|integer',
            'assignments' => 'nullable|integer',
            'status' => 'required|string',
            'progress' => 'nullable|integer',
            'nextClass' => 'nullable|string',
        ]);

        // Demo-only: mutate in-memory structure
        $this->courseData[$validated['id']] = array_merge([
            'icon' => $validated['icon'] ?? 'fas fa-book',
            'students' => $validated['students'] ?? 0,
            'assignments' => $validated['assignments'] ?? 0,
            'progress' => $validated['progress'] ?? 0,
            'nextClass' => $validated['nextClass'] ?? 'TBA',
            'instructor' => 'Dr. Lorenz',
        ], $validated);

        return redirect()->route('instructor.courses.')->with('status', 'Course created.');
    }

}
