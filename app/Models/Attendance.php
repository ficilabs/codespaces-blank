<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'school_day_id',
        'status',
        'note',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function schoolDay()
    {
        return $this->belongsTo(SchoolDay::class);
    }
}

