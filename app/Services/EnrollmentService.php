<?php

namespace App\Services;

use App\Models\Course;
use App\Models\User;

/**
 * Class EnrollmentService.
 */
class EnrollmentService
{

    public function enroll(User $user, Course $course)
    {

        if ($user->courses()->where('course_id', $course->id)->exists()) {
            return false; // Already enrolled
        }

        // logic for enrolling user
        $user->courses()->attach($course->id);

        return true;
    }

    public function unenroll(User $user, string $courseId)
    {
        $user->courses()->detach($courseId);
    }

    public function isUserEnrolled(User $user, Course $course)
    {
        return $user->courses()->where('course_id', $course->id)->exists();
    }

}
