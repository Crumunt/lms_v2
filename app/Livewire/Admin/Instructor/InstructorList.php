<?php

namespace App\Livewire\Admin\Instructor;

use App\Models\User;
use Livewire\Component;

class InstructorList extends Component
{
    public $searchTerm = '';
    public $statusFilter = 'all';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    protected $listeners = ['instructorDeleted' => '$refresh'];

    public function deleteInstructor($instructorId)
    {
        try {
            $course = User::findOrFail($instructorId);

            // Add authorization check if needed

            $course->delete();

            session()->flash('message', 'Instructor deleted successfully.');

            // Dispatch event to refresh component
            $this->dispatch('instructorDeleted');

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

        $query = User::role('instructor')->withCount('taughtCourses');


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
            $query->whereHas('detail', function($q) {
                $q->where('status', $this->statusFilter);
            });
        }

        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        // Get results
        $instructors = $query->paginate(10);

        return view('livewire.admin.instructor.instructor-list', [
            'instructors' => $instructors
        ]);
    }
}
