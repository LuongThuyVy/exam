<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'Id',
        'Name',
        'Description',
        'Duration',
        'TotalQuestions',
        'SubjectGradeId',
    ];

    public $timestamps = false; 

    public function subject_grade()
    {
        return $this->belongsTo(SubjectGrade::class, 'SubjectGradeId', 'Id');
    }  return $this->belongsTo(Grade::class, 'GradeId');
    
}
