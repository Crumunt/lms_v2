<?php

namespace App\Livewire\Admin\Student;

use App\Models\User;
use Livewire\Component;

class StudentList extends Component
{
    public $searchTerm = '';
    public $statusFilter = 'all';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    protected $listeners = ['studentDeleted' => '$refresh'];

    public function deleteStudent($instructorId)
    {
        try {
            $course = User::findOrFail($instructorId);

            // Add authorization check if needed

            $course->delete();

            session()->flash('message', 'Instructor deleted successfully.');

            // Dispatch event to refresh component
            $this->dispatch('studentDeleted');

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to delete course: ' . $e->getMessage());
        }
    }

    /**
     * Sort table by column
     */
    public function sortBy($field)
    {
        // Toggle direction if clicking same column
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            // New column, default to ascending
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }

    /**
     * Reset filters
     */
    public function resetFilters()
    {
        $this->searchTerm = '';
        $this->statusFilter = 'all';
        $this->sortBy = 'created_at';
        $this->sortDirection = 'desc';
    }

    public function render()
    {

        $query = User::role('student')->withCount('enrollments');


        // Apply search filter
        if ($this->searchTerm) {
            $query->where(function ($q) {
                $q->whereHas('detail', function ($q2) {
                    $q2->where('full_name', 'like', '%' . $this->searchTerm . '%');
                });
            });
        }

        // Apply status filter
        if ($this->statusFilter !== 'all') {
            $query->whereHas('details', function($q) {
                $q->where('status', $this->statusFilter);
            });
        }

        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        // Get results
        $students = $query->withStatusData();

        $students_stats = [
            'total' => $students->count(),
            'active' => User::role('student')->whereHas('detail', fn($q) => $q->where('status', 'active'))->count(),
            'total_enrolled' => $students->sum('enrollments_count')
        ];
        
        return view('livewire.admin.student.student-list', compact('students', 'students_stats'));
    }
}
