<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $table = 'exams';

    protected $fillable = ['Name', 'Description', 'Duration', 'TotalQuestions', 'SubjectGradeId'];

    public function subjectGrade()
    {
        return $this->belongsTo(SubjectGrade::class, 'SubjectGradeId');
    }

    public function subject()
    {
        return $this->hasOneThrough(Subject::class, SubjectGrade::class, 'Id', 'Id', 'SubjectGradeId', 'SubjectId');
    }

    public function grade()
    {
        return $this->hasOneThrough(Grade::class, SubjectGrade::class, 'Id', 'Id', 'SubjectGradeId', 'GradeId');
    }
}
