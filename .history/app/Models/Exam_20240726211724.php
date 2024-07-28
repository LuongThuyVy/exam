<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        Id',
        'Name',
        'Description',
        'Duration',
        'TotalQuestions',
        'SubjectId',
        'GradeId',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'SubjectId');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'GradeId');
    }
}
