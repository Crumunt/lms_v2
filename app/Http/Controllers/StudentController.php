<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\CourseContent;
use App\Http\Controllers\EnrollmentController;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function dashboard($studentId = null)
    {
        // If studentId is provided (from test route), use it; otherwise use authenticated user or first student
        $currentStudentId = $studentId ?? (auth()->id() ?? \App\Models\User::where('role', 'student')->first()->id ?? 1);

        $user = [
            'name' => 'Francis',
            'program' => 'BS Computer Science',
            'initials' => 'JD'
        ];

        $stats = [
            [
                'icon' => 'fas fa-book',
                'iconBg' => 'bg-gradient-to-br from-blue-400 to-blue-600',
                'value' => '5',
                'label' => 'Active Courses',
                'progress' => 75
            ],
            [
                'icon' => 'fas fa-check-circle',
                'iconBg' => 'bg-gradient-to-br from-green-400 to-green-600',
                'value' => '23',
                'label' => 'Completed Tasks',
                'progress' => 85
            ],
            [
                'icon' => 'fas fa-trophy',
                'iconBg' => 'bg-gradient-to-br from-purple-400 to-purple-600',
                'value' => '92%',
                'label' => 'Average Grade',
                'progress' => 92
            ],
            [
                'icon' => 'fas fa-clock',
                'iconBg' => 'bg-gradient-to-br from-orange-400 to-orange-600',
                'value' => '48h',
                'label' => 'Study Time',
                'progress' => 60
            ]
        ];

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

        $activities = [
            [
                'type' => 'completed',
                'icon' => 'fas fa-check',
                'iconBg' => 'bg-green-100',
                'iconColor' => 'text-green-600',
                'title' => 'Completed Assignment',
                'description' => 'Programming Exercise 3 - Introduction to Programming',
                'time' => '2 hours ago'
            ],
            [
                'type' => 'video',
                'icon' => 'fas fa-video',
                'iconBg' => 'bg-blue-100',
                'iconColor' => 'text-blue-600',
                'title' => 'Watched Video',
                'description' => 'Database Normalization - Database Management',
                'time' => '4 hours ago'
            ],
            [
                'type' => 'comment',
                'icon' => 'fas fa-comment',
                'iconBg' => 'bg-purple-100',
                'iconColor' => 'text-purple-600',
                'title' => 'Posted Comment',
                'description' => 'Computer Networks Discussion Forum',
                'time' => '1 day ago'
            ],
            [
                'type' => 'download',
                'icon' => 'fas fa-download',
                'iconBg' => 'bg-orange-100',
                'iconColor' => 'text-orange-600',
                'title' => 'Downloaded Resource',
                'description' => 'Mobile App Development - React Native Guide',
                'time' => '2 days ago'
            ]
        ];

        $events = [
            [
                'day' => '15',
                'bgColor' => 'bg-red-500',
                'borderColor' => 'border-red-100',
                'bgLight' => 'bg-red-50',
                'title' => 'Database Quiz',
                'description' => 'Database Management - CS 201',
                'dueDate' => 'Due: Tomorrow, 2:00 PM',
                'dueColor' => 'text-red-600',
                'badge' => 'Urgent',
                'badgeColor' => 'bg-red-100 text-red-800'
            ],
            [
                'day' => '18',
                'bgColor' => 'bg-yellow-500',
                'borderColor' => 'border-yellow-100',
                'bgLight' => 'bg-yellow-50',
                'title' => 'Programming Assignment',
                'description' => 'Introduction to Programming - CS 101',
                'dueDate' => 'Due: Jan 18, 11:59 PM',
                'dueColor' => 'text-yellow-600',
                'badge' => '3 days',
                'badgeColor' => 'bg-yellow-100 text-yellow-800'
            ],
            [
                'day' => '20',
                'bgColor' => 'bg-blue-500',
                'borderColor' => 'border-blue-100',
                'bgLight' => 'bg-blue-50',
                'title' => 'Midterm Exam',
                'description' => 'Computer Networks - CS 301',
                'dueDate' => 'Jan 20, 9:00 AM',
                'dueColor' => 'text-blue-600',
                'badge' => '5 days',
                'badgeColor' => 'bg-blue-100 text-blue-800'
            ],
            [
                'day' => '22',
                'bgColor' => 'bg-green-500',
                'borderColor' => 'border-green-100',
                'bgLight' => 'bg-green-50',
                'title' => 'Project Presentation',
                'description' => 'Mobile App Development - CS 401',
                'dueDate' => 'Jan 22, 1:00 PM',
                'dueColor' => 'text-green-600',
                'badge' => '1 week',
                'badgeColor' => 'bg-green-100 text-green-800'
            ]
        ];

        // Reflect session enrollment state in dashboard course list
        // Get enrolled courses from database
        $enrollmentController = new EnrollmentController();
        $enrolledCourses = $enrollmentController->getEnrolledCourses($currentStudentId);

        // Convert to the format expected by the dashboard
        $courses = $enrolledCourses->map(function ($course) {
            return [
                'id' => $course['id'],
                'title' => $course['title'],
                'code' => $course['code'],
                'description' => $course['description'],
                'progress' => rand(20, 90), // Random progress for demo
                'students' => rand(20, 60), // Random student count for demo
                'icon' => 'fas fa-book'
            ];
        })->toArray();

        return view('student.dashboard', compact('user', 'stats', 'courses', 'activities', 'events'));
    }

    public function courses()
    {
        $user = [
            'name' => 'Francis',
            'program' => 'BS Computer Science',
            'initials' => 'JD'
        ];

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

        // Get enrolled courses from database
        $enrollmentController = new EnrollmentController();
        $studentId = auth()->id() ?? \App\Models\User::where('role', 'student')->first()->id ?? 1;
        $enrolledCourses = $enrollmentController->getEnrolledCourses($studentId);

        return view('student.courses', compact('user', 'notifications', 'enrolledCourses'));
    }

    public function showCourse($id)
    {
        $courseData = [
            'id' => 'cs101',
            'title' => 'Introduction to Programming',
            'code' => 'CS 101 - 3 Units',
            'description' => 'This course introduces students to the fundamental concepts of computer programming. Students will learn problem-solving techniques, algorithm design, and implementation using modern programming languages. The course covers variables, control structures, functions, arrays, and object-oriented programming principles.',
            'progress' => 78,
            'enrolled' => true,
            'enrollmentDate' => 'Jan 15, 2025',
            'icon' => 'fas fa-code',
            'instructor' => [
                'name' => 'Dr. John Smith',
                'department' => 'Computer Science Department',
                'email' => 'j.smith@clsu.edu.ph',
                'initials' => 'JS'
            ]
        ];

        $user = [
            'name' => 'Francis',
            'program' => 'BS Computer Science',
            'initials' => 'JD'
        ];

        $notifications = ['courses' => 5, 'assignments' => 2];

        // Get course from database
        $course = Course::with('instructor')->find($id);

        if (!$course) {
            // abort(404);
        }

        // Check if student is enrolled
        // $studentId = Auth::id() ?? \App\Models\User::where('role', 'student')->first()->id ?? 1;
        // $enrollment = Enrollment::where('student_id', $studentId)
        //     ->where('course_id', $id)
        //     ->where('status', 'active')
        //     ->first();

        // if (!$enrollment) {
        //     return redirect()->route('student.catalog')->with('error', 'You are not enrolled in this course.');
        // }

        // Get course content
        // $contents = CourseContent::where('course_id', $id)
        //     ->where('status', 'published')
        //     ->orderBy('created_at', 'desc')
        //     ->get()
        //     ->map(function ($content) {
        //         return [
        //             'id' => $content->id,
        //             'title' => $content->title,
        //             'description' => $content->description,
        //             'type' => 'pdf',
        //             'uploaded_at' => $content->uploaded_at->format('M j, Y'),
        //             'status' => $content->status,
        //             'file_path' => $content->file_path
        //         ];
        //     });

        // $courseData = [
        //     'id' => $course->id,
        //     'title' => $course->title,
        //     'code' => $course->code,
        //     'description' => $course->description,
        //     'instructor' => [
        //         'name' => $course->instructor->name,
        //         'department' => 'Computer Science Department',
        //         'email' => $course->instructor->email,
        //         'initials' => substr($course->instructor->name, 0, 2)
        //     ],
        //     'enrolled' => true,
        //     'enrollmentDate' => $enrollment->enrolled_at->format('M j, Y'),
        //     'icon' => 'fas fa-book'
        // ];

        return view('student.course.show', compact('user', 'notifications', 'courseData', 'contents'));
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
        $user = [
            'name' => 'Francis',
            'program' => 'BS Computer Science',
            'initials' => 'JD'
        ];

        // Use same demo course dataset as other methods
        $all = [
            ['id' => 'cs101', 'title' => 'Introduction to Programming', 'code' => 'CS 101', 'description' => 'Learn the fundamentals of computer programming with Python and JavaScript.', 'progress' => 78, 'students' => 45, 'icon' => 'fas fa-code'],
            ['id' => 'cs201', 'title' => 'Database Management', 'code' => 'CS 201', 'description' => 'Master SQL and database design principles for modern applications.', 'progress' => 65, 'students' => 38, 'icon' => 'fas fa-database'],
            ['id' => 'cs301', 'title' => 'Computer Networks', 'code' => 'CS 301', 'description' => 'Understanding network protocols, security, and infrastructure.', 'progress' => 42, 'students' => 52, 'icon' => 'fas fa-network-wired'],
            ['id' => 'cs401', 'title' => 'Mobile App Development', 'code' => 'CS 401', 'description' => 'Build cross-platform mobile applications using React Native.', 'progress' => 90, 'students' => 29, 'icon' => 'fas fa-mobile-alt'],
            ['id' => 'cs501', 'title' => 'Cybersecurity Fundamentals', 'code' => 'CS 501', 'description' => 'Learn about network security, encryption, and ethical hacking.', 'progress' => 35, 'students' => 41, 'icon' => 'fas fa-shield-alt'],
            ['id' => 'cs601', 'title' => 'Artificial Intelligence', 'code' => 'CS 601', 'description' => 'Introduction to machine learning, neural networks, and AI algorithms.', 'progress' => 28, 'students' => 33, 'icon' => 'fas fa-brain'],
        ];

        $notifications = ['courses' => 5, 'assignments' => 2];

        // Get available courses from database
        $enrollmentController = new EnrollmentController();
        $studentId = auth()->id() ?? \App\Models\User::where('role', 'student')->first()->id ?? 1;

        $availableCourses = $enrollmentController->getAvailableCourses($studentId);

        return view('student.catalog', compact('user', 'notifications', 'availableCourses'));
    }
}
