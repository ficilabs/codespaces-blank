<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassGroup extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade_id',
        'group_number',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class);
    }

}
