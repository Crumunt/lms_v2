<?php

namespace App\Models;

use App\UserStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetails extends Model
{
    //
    use HasFactory;

    protected $casts = [
        'status' => UserStatus::class
    ];

    protected $primaryKey = 'user_id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'full_name',
        'address',
        'status',
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
