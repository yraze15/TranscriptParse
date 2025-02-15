<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_no',
        'student_name',
        'gender',
        'birth_date',
        'department',
        'specialization',
        'probation'
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
