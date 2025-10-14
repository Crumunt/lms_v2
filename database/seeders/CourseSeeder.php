<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the instructor
        $instructor = User::whereHas('roles', function ($query) {
            $query->where('name', 'instructor');
        })->with('roles')->first();


        if (!$instructor) {
            $this->command->error('No instructor found. Please run AdminSeeder first.');
            return;
        }

        // Create sample courses
        $courses = [
            [
                'title' => 'Introduction to Programming',
                'code' => 'CS101',
                'description' => 'This course introduces students to the fundamental concepts of computer programming. Students will learn problem-solving techniques, algorithm design, and implementation using modern programming languages. The course covers variables, control structures, functions, arrays, and object-oriented programming principles.',
                'status' => 'approved',
                'difficulty' => 'beginner',
                'enrollment_count' => 0,
            ],
            [
                'title' => 'Database Management Systems',
                'code' => 'CS201',
                'description' => 'Master SQL and database design principles for modern applications. Learn about relational database concepts, normalization, indexing, and query optimization. Students will work with real-world database scenarios.',
                'status' => 'approved',
                'difficulty' => 'intermediate',
                'enrollment_count' => 0,
            ],
            [
                'title' => 'Computer Networks',
                'code' => 'CS301',
                'description' => 'Understanding network protocols, security, and infrastructure. Learn about TCP/IP, routing, switching, and network security fundamentals. This course covers both theoretical concepts and practical applications.',
                'status' => 'approved',
                'difficulty' => 'intermediate',
                'enrollment_count' => 0,
            ],
            [
                'title' => 'Mobile App Development',
                'code' => 'CS401',
                'description' => 'Build cross-platform mobile applications using React Native. Learn about mobile UI/UX design, state management, and app deployment. Students will create real mobile applications.',
                'status' => 'approved',
                'difficulty' => 'advanced',
                'enrollment_count' => 0,
            ],
            [
                'title' => 'Cybersecurity Fundamentals',
                'code' => 'CS501',
                'description' => 'Learn about network security, encryption, and ethical hacking. Understand security threats, vulnerabilities, and defense mechanisms. This course provides hands-on experience with security tools.',
                'status' => 'approved',
                'difficulty' => 'advanced',
                'enrollment_count' => 0,
            ],
            [
                'title' => 'Artificial Intelligence',
                'code' => 'CS601',
                'description' => 'Introduction to machine learning, neural networks, and AI algorithms. Explore supervised and unsupervised learning techniques, deep learning, and AI applications in real-world scenarios.',
                'status' => 'approved',
                'difficulty' => 'advanced',
                'enrollment_count' => 0,
            ],
        ];

        foreach ($courses as $courseData) {
            Course::create([
                'id' => (string) Str::uuid(),
                'title' => $courseData['title'],
                'code' => $courseData['code'],
                'description' => $courseData['description'],
                'instructor_id' => $instructor->id,
                'status' => $courseData['status'],
                'difficulty' => $courseData['difficulty'],
                'enrollment_count' => $courseData['enrollment_count'],
            ]);
        }

        // $this->command->info('Created ' . count($courses) . ' sample courses for testing!');
        // $this->command->info('Courses are now available for student enrollment.');
    }
}