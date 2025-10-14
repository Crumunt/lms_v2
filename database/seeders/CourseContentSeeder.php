<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\CourseContent;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CourseContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the first course (Introduction to Programming)
        $course = Course::where('code', 'CS101')->first();
        
        if (!$course) {
            $this->command->error('CS101 course not found. Please run CourseSeeder first.');
            return;
        }

        // Create sample course content
        $contents = [
            [
                'title' => 'Week 1: Introduction to Programming Concepts',
                'description' => 'Overview of programming fundamentals, variables, and basic syntax. This module covers the basic building blocks of programming including data types, variables, and simple operations.',
                'status' => 'published',
                'uploaded_at' => now()->subDays(7),
            ],
            [
                'title' => 'Week 2: Control Structures and Loops',
                'description' => 'Learn about if-else statements, loops, and program flow control. This module teaches how to make programs make decisions and repeat operations efficiently.',
                'status' => 'published',
                'uploaded_at' => now()->subDays(5),
            ],
            [
                'title' => 'Week 3: Functions and Modules',
                'description' => 'Understanding function creation, parameters, and code organization. This module covers how to break down complex programs into manageable, reusable pieces.',
                'status' => 'published',
                'uploaded_at' => now()->subDays(3),
            ],
            [
                'title' => 'Week 4: Arrays and Data Structures',
                'description' => 'Working with arrays, lists, and basic data structures. This module introduces how to store and manipulate collections of data.',
                'status' => 'published',
                'uploaded_at' => now()->subDays(1),
            ],
            [
                'title' => 'Week 5: Object-Oriented Programming Basics',
                'description' => 'Introduction to classes, objects, and OOP principles. This module covers the fundamental concepts of object-oriented programming.',
                'status' => 'draft',
                'uploaded_at' => now(),
            ],
        ];

        foreach ($contents as $contentData) {
            CourseContent::create([
                'id' => (string) Str::uuid(),
                'course_id' => $course->id,
                'title' => $contentData['title'],
                'description' => $contentData['description'],
                'file_path' => 'sample/course_contents/dr-lorenz/' . $course->id . '/sample_' . strtolower(str_replace(' ', '_', $contentData['title'])) . '.pdf',
                'status' => $contentData['status'],
                'uploaded_at' => $contentData['uploaded_at'],
            ]);
        }

        $this->command->info('Created ' . count($contents) . ' sample course content items for CS101!');
        $this->command->info('Course materials are now available for students to view.');
    }
}