<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'academic_year',
        'semester',
        'course_no',
        'course_name',
        'credit_hours',
        'grade',
        'points',
        'note',
        'result'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
