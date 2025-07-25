<?php

namespace App\Models;

use App\Models\Courses;
use App\Models\Students;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $table = 'enrollment';
    protected $primaryKey = 'enrollment_id';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'enrollment_id',
        'student_id',
        'course_id',
        'grade',
        'attendance',
        'status',
    ];

    public function student()
    {
        return $this->belongsTo(Students::class, 'student_id', 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(Courses::class, 'course_id', 'course_id');
    }
}
