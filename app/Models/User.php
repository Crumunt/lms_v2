<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Helpers\AdminUserHelper;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasUuids;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */

    protected $fillable = [
        'email',
        'password',
        'status',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function detail()
    {
        return $this->hasOne(UserDetails::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrollments', 'student_id', 'course_id')->withTimestamps();
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id', 'id');
    }

    public function enrolledAssignments()
    {
        return Assignment::whereIn('course_id', $this->courses()->pluck('id'));
    }


    public function taughtCourses()
    {
        return $this->hasMany(Course::class, 'instructor_id');
    }

    /**
     * Scope a query to only include approved users.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }


    public function scopeWithStatusData($query)
    {
        return $query->paginate(10)->map(function ($user) {
            $status = $user->detail?->status->name;
            $user->status_badge = AdminUserHelper::getStatusBadge($status);
            $user->status_class = AdminUserHelper::getStatusBadgeClass($status);
            $user->status_text_class = AdminUserHelper::getStatusTextClass($status);
            $user->status_label = AdminUserHelper::getStatusLabel($status);
            return $user;
        });
    }
}
