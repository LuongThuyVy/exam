<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamShift extends Model
{
    use HasFactory;

    protected $table = 'exam_shifts';
    protected $primaryKey = 'Id';

    protected $fillable = [
        'Name',
        'StartTime',
        'EndTime',
        'ExamId',
    ];

    public $timestamps = false;

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'ExamId','Id');
    }
}
