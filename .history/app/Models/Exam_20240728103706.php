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
 <!--
Illuminate\Database\Eloquent\RelationNotFoundException: Call to undefined relationship [examQuestions] on model [App\Models\Exam]. in file C:\Users\DELL\example\exam\vendor\laravel\framework\src\Illuminate\Database\Eloquent\RelationNotFoundException.php on line 35

  
}
