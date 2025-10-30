<?php

namespace App\Livewire\Instructor\Course;

use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;

class EnrolledStudentsTable extends Component
{

    use WithPagination;

    public $perPage = 10;
    private $courseId;
    protected $paginationTheme = 'tailwind';

    public function mount($courseId) {

        $this->courseId = $courseId;
    }

    public function render()
    {

        $course = Course::findOrFail($this->courseId);
        $students = $course->students()->paginate(10);

        return view('livewire.instructor.course.enrolled-students-table', [
            'course' => $course,
            'students' => $students
        ]);
    }
}
