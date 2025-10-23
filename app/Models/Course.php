<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    use HasFactory;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'title',
        'code',
        'description',
        'instructor_id',
        'status',
        'difficulty',
        'enrollment_count',
    ];

    protected $casts = [
        'enrollment_count' => 'integer',
    ];

    /**
     * Get the instructor that owns the course.
     */
    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'student_id')->withTimestamps();
    }

    /**
     * Get the course contents for the course.
     */
    public function contents(): HasMany
    {
        return $this->hasMany(CourseContent::class);
    }

    /**
     * Get the enrollments for the course.
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * Scope a query to only include approved courses.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Scope a query to only include active courses.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
