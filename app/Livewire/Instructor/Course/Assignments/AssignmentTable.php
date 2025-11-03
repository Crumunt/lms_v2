<?php

namespace App\Livewire\Instructor\Course\Assignments;

use App\Models\Course;
use Livewire\Component;

class AssignmentTable extends Component
{
    private $course;
    public $search;

    public function mount(Course $course)
    {
        $this->course = $course;
    }

    public function render()
    {
        $assignments = $this->course->assignments()->where('title', 'like', "%{$this->search}%")->withSubmissionCount()->latest()->get();
        $course = $this->course;

        return view('livewire.instructor.course.assignments.assignment-table', compact('assignments', 'course'));
    }
}
