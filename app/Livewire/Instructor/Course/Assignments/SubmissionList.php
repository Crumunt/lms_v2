<?php

namespace App\Livewire\Instructor\Course\Assignments;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class SubmissionList extends Component
{
    public $assignment;
    public $submissions;

    // Modal state
    public $showGradeModal = false;
    public $selectedSubmission = null;
    public $score;
    public $maxScore;
    public $submissionDate = null;

    public $message = null;

    protected $rules = [
        'score' => 'required|numeric|min:0',
    ];

    public function mount(Assignment $assignment)
    {
        $this->assignment = $assignment;
        $this->maxScore = $assignment->total_points;
        $this->loadSubmissions();
    }

    public function loadSubmissions()
    {
        $this->submissions = $this->assignment->submissions()
            ->with('student')
            ->latest('submitted_at')
            ->get();
    }

    public function openGradeModal($submissionId)
    {
        $this->selectedSubmission = AssignmentSubmission::with('student')->findOrFail($submissionId);
        $this->submissionDate = $this->selectedSubmission->submitted_at->format('M d, Y \a\t h:i A');
        $this->score = $this->selectedSubmission->score ?? '';
        $this->showGradeModal = true;
    }

    public function closeGradeModal()
    {
        $this->showGradeModal = false;
        $this->selectedSubmission = null;
        $this->score = '';
        $this->resetValidation();
    }

    public function updatedScore($value)
    {
        if ($value > $this->maxScore) {
            $this->score = $this->maxScore;
        }
    }

    public function saveGrade()
    {
        $this->validate([
            'score' => "required|numeric|min:0|max:{$this->maxScore}"
        ]);

        activity('Grading Assignment')
            ->withProperties([
                'submission_id' => $this->selectedSubmission->id,
                'assignment_id' => $this->assignment->id,
                'assignment_name' => $this->assignment->title,
                'student_id' => $this->selectedSubmission->student?->id,
                'student_name' => $this->selectedSubmission->student?->detail?->full_name,
                'graded_by' => Auth::id()
            ])
            ->log('Instructor has graded an assignment.');

        $this->selectedSubmission->update([
            'score' => $this->score,
            'status' => 'graded',
            'graded_at' => now(),
            'graded_by' => Auth::id(),
        ]);

        $this->loadSubmissions();
        $this->closeGradeModal();

        $this->message = 'Grade saved successfully!';
    }

    public function dismissMessage()
    {
        $this->message = '';
    }

    public function render()
    {
        return view('livewire.instructor.course.assignments.submission-list');
    }
}
