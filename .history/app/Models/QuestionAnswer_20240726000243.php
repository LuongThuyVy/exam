<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionAnswer extends Model
{
    use HasFactory;

    protected $table = 'question_answers';

    protected $fillable = [
        'Content',
        'Difficulty',
        'OptionA',
        'OptionB',
        'OptionC',
        'OptionD',
        'CorrectOption',
        'SubjectGradeId',
    ];

    public $timestamps = false; 

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'SubjectId', 'Id');
    }

}


