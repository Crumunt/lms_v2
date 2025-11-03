<?php

namespace App\Livewire\Admin\Course;

use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;

class CourseList extends Component
{
    use WithPagination;

    public $searchTerm = '';
    public $statusFilter = 'all';
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';

    // Event listeners
    protected $listeners = ['courseDeleted' => '$refresh'];


    public function deleteCourse($courseId)
    {
        try {
            $course = Course::findOrFail($courseId);

            // Add authorization check if needed

            $course->delete();

            session()->flash('message', 'Course deleted successfully.');

            // Dispatch event to refresh component
            $this->dispatch('courseDeleted');

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

    /**
     * Render the component
     */
    public function render()
    {
        // Build query with eager loading
        $query = Course::with('instructor')
            ->withCount('enrollments');

        // Apply search filter
        if ($this->searchTerm) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('code', 'like', '%' . $this->searchTerm . '%')
                    ->orWhereHas('instructor', function ($q) {
                        $q->whereHas('detail', function ($q2) {
                            $q2->where('full_name', 'like', '%' . $this->searchTerm . '%');
                        });
                    });
            });
        }

        // Apply status filter
        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        // Get results
        $courses = $query->paginate(10);

        // Calculate stats
        return view('livewire.admin.course.course-list', [
            'courses' => $courses,
            'totalCourses' => $courses->count(),
            'publishedCourses' => $courses->where('status', 'approved')->count(),
            'totalEnrollments' => $courses->sum('enrollments_count'),
        ]);
    }
}
