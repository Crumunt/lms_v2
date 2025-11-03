<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    //
    use HasUuids;

    protected $fillable = [
        'assignment_id',
        'student_id',
        'file_path',
        'status',
        'score',
        'feedback',
        'submitted_at',
        'graded_at',
        'graded_by',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'graded_at' => 'datetime',
        'score' => 'integer',
    ];

    // Relationships
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function checkIfLate()
    {
        if (!$this->assignment->due_date || !$this->submitted_at) {
            return false;
        }

        return $this->submitted_at->gt($this->assignment->due_date);
    }

    protected static function booted()
    {
        static::creating(function ($submission) {
            if ($submission->status === 'submitted' && $submission->submitted_at) {
                $submission->is_late = $submission->checkIfLate();
            }
        });

        static::updating(function ($submission) {
            if ($submission->isDirty('status') && $submission->status === 'submitted') {
                $submission->submitted_at = $submission->submitted_at ?? now();
                $submission->is_late = $submission->checkIfLate();
            }

            if ($submission->isDirty('status') && $submission->status === 'graded') {
                $submission->graded_at = $submission->graded_at ?? now();
            }
        });
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function grader()
    {
        return $this->belongsTo(User::class, 'graded_by');
    }

    public function scopeGraded($query)
    {
        return $query->where('status', 'graded');
    }

    public function scopeSubmitted($query)
    {
        return $query->where('status', 'submitted')->orWhere('status', 'graded');
    }

    public function scopeLate($query)
    {
        return $query->where('status', 'late');
    }

    public function scopePendingGrading($query)
    {
        return $query->where('status', 'submitted')->whereNull('graded_at');
    }
}
