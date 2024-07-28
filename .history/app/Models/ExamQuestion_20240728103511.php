<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    use HasFactory;
    
    protected $table = 'exam_questions';

    protected $fillable = [
        'Sequence',
        'ExamId',
        'QuestionAnswerId',
    ];
    public $timestamps = false; 
    public function exam()
    {
        return $this->belongsTo(Exam::class, 'ExamId');
    }

    public function question_answer()
    {
        return $this->belongsTo(QuestionAnswer::class, 'QuestionAnswerId');
    }
   
}
