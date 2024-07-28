<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $table = 'exams';

    protected $fillable = ['Id','Name', 'Description', 'Duration', 'TotalQuestions', 'SubjectGradeId'];

    public function subjectGrade()
    {
        return $this->belongsTo(SubjectGrade::class, 'SubjectGradeId');
    }
    public function examQuestions()
    {
        return $this->hasMany(ExamQuestion::class, 'ExamId');
    }
  
}
