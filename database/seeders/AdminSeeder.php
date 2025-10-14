<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Course;
use App\Models\CourseContent;
use App\Models\Enrollment;
use Database\Factories\UserFactory;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        $admin = User::factory()->admin()->create();

        // Create Sample Instructors
        $instructor1 = User::factory()->instructor()->count(2)->create();

        // Create Sample Students
        $student1 = User::factory()->student()->count(3)->create();


        // $this->command->info('Sample data created successfully!');
        // $this->command->info('Admin Login: admin@clsu.edu.ph / password');
        // $this->command->info('Instructor Login: maria.santos@clsu.edu.ph / password');
        // $this->command->info('Student Login: john.smith@student.clsu.edu.ph / password');
    }
}