<?php

namespace App\Livewire\Instructor\Students;

use App\Models\Enrollment;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class EnrolledStudentsTable extends Component
{

    use WithPagination;

    public function render()
    {
        $instructor = Auth::user();
        $enrolledStudents = Enrollment::whereHas('course', function ($q) use ($instructor) {
            $q->where('instructor_id', $instructor->id);
        })->with(['user', 'course'])->get();

        return view('livewire.instructor.students.enrolled-students-table', compact('enrolledStudents'));
    }
}
