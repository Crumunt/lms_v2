<?php

namespace App\Livewire\Student;

use App\Models\Course;
use App\Services\EnrollmentService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Spatie\Activitylog\Contracts\Activity;

class StudentCourseCatalog extends Component
{
    public $user;
    public $isEnroll;
    protected $enrollmentService;

    public function boot(EnrollmentService $enrollmentService)
    {
        $this->enrollmentService = $enrollmentService;

    }

    public function mount($isEnroll = true)
    {
        $this->user = Auth::user();
        $this->isEnroll = $isEnroll;
    }

    private function fetchAvailableCourses()
    {
        
        if ($this->isEnroll) {
            $enrolledCourses = $this->user->courses()->pluck('id');
            $availableCourses = Course::whereNotIn('id', $enrolledCourses)->with('instructor')->get();
        }else {
            $availableCourses = $this->user->courses()->with(['instructor', 'enrollments'])->get();
        }

        return $availableCourses;
    }

    public function enroll(string $courseId)
    {
        $course = Course::findOrFail($courseId);

        $success = $this->enrollmentService->enroll($this->user, $course);

        if ($success) {
            activity('enrollment')
            ->performedOn($course)
            ->withProperties([
                'course_id' => $course->id,
                'course_name' => $course->title,
                'course_code' => $course->code
            ])
            ->log('Enrolled in course');
            session()->flash('message', 'Successfully Enrolled in Course!.');
        } else {
            session()->flash('message', 'Something went wrong!.');
        }

    }

    public function cancelEnrollment(string $courseId)
    {
        $course = Course::findOrFail($courseId);

        $success = $this->enrollmentService->cancel($this->user, $course);

        if ($success) {
            session()->flash('message', 'Successfully cancelled enrollment in Course!.');
        } else {
            session()->flash('message', 'Something went wrong!.');
        }
    }

    public function render()
    {
        return view('livewire.student.student-course-catalog', ['courses' => $this->fetchAvailableCourses(), 'isEnroll' => $this->isEnroll]);
    }
}
