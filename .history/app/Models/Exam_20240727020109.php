<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['Name', 'SubjectGradeId'];

    // Quan hệ với SubjectGrade
    public function subjectGrade()
    {
        return $this->belongsTo(SubjectGrade::class, 'SubjectGradeId');
    }

    // Quan hệ với Subject thông qua SubjectGrade
    public function subject()
    {
        return $this->hasOneThrough(
            Subject::class,
            SubjectGrade::class,
            'Id', // Foreign key on SubjectGrade
            'Id', // Foreign key on Subject
            'SubjectGradeId', // Local key on Exam
            'SubjectId' // Local key on SubjectGrade
        );
    }

    // Quan hệ với Grade thông qua SubjectGrade
    public function grade()
    {
        return $this->hasOneThrough(
            Grade::class,
            SubjectGrade::class,
            'Id', // Foreign key on SubjectGrade
            'Id', // Foreign key on Grade
            'SubjectGradeId', // Local key on Exam
            'GradeId' // Local key on SubjectGrade
        );
    }
}
