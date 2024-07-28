<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    protected $table = 'exam_questions';
    protected $fillable = [
        'ExamineeId', 'ExamShiftId', 'Score', 'CompletionTime'
    ];

    public function examinee()
    {
        return $this->belongsTo(Examinee::class, 'ExamineeId');
    }

    public function examShift()
    {
        return $this->belongsTo(ExamShift::class, 'ExamShiftId');
    }
}
