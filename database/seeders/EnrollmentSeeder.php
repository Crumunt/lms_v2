<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get the student
        $student = User::whereHas('roles', function ($query) {
            $query->where('name', 'student');
        })->with('roles')->first();


        if (!$student) {
            $this->command->error('No student found. Please run AdminSeeder first.');
            return;
        }

        // Get the first course (Introduction to Programming)
        $course = Course::where('code', 'CS101')->first();

        if (!$course) {
            $this->command->error('CS101 course not found. Please run CourseSeeder first.');
            return;
        }

        // Create sample enrollment
        Enrollment::create([
            'id' => (string) Str::uuid(),
            'student_id' => $student->id,
            'course_id' => $course->id,
            'enrolled_at' => now()->subDays(10),
            'status' => 'active',
        ]);

        // Update course enrollment count
        $course->increment('enrollment_count');

        // $this->command->info('Created sample enrollment for student in CS101!');
        // $this->command->info('Student can now view the enrolled course and its materials.');
    }
}