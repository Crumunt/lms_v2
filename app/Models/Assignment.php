<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Assignment extends Model
{
    //
    use HasUuids;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'total_points',
        'due_date',
        'allow_late_submission',
        'submission_type',
        'status',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'allow_late_submission' => 'boolean',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    public function scopeWithSubmissionCount($query)
    {
        return $query->withCount([
            'submissions',
            'submissions as pending_submissions_count' => function ($query) {
                $query->where('status', 'submitted');
            },
            'submissions as graded_submissions_count' => function ($query) {
                $query->where('status', 'graded');
            },
        ]);
    }

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeClosed($query)
    {
        return $query->where('status', 'closed');
    }

    public function isOverdue()
    {
        return $this->due_date && $this->due_date->isPast();
    }
}
