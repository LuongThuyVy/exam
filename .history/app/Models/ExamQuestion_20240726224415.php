<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'Sequence',
        'ExamId',
        'QuestionAnswerId',
    ];

    public function exam()
    {
        return $this->belongsTo(SubjectGrade::class, 'SubjectGradeId', 'Id');
    }
}
