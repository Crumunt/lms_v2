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

        if ($this->isUserEnrolled($user, $course)) {
            return false; // Already enrolled
        }

        // logic for enrolling user
        try {
            $user->courses()->attach($course->id);

            return true;
        } catch (\Exception $e) {
            return false;
        }

    }

    public function cancel(User $user, Course $course)
    {
        if (!$this->isUserEnrolled($user, $course)) {
            return false; // isn't enrolled
        }

        $detach = $user->courses()->detach($course->id);

        return $detach > 0;
    }

    public function isUserEnrolled(User $user, Course $course)
    {
        return $user->courses->contains($course);
    }

}
