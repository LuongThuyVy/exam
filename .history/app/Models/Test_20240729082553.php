<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Test extends Model
{
    use HasFactory;
    protected $table = 'tests';
    protected $fillable = [
        'ExamineeId', 'ExamShiftId', 'Score', 'CompletionTime'
    ];
    public $timestamps = false;

    public function examinee()
    {
        return $this->belongsTo(Examinee::class, 'ExamineeId');
    }

    public function examShift()
    {
        return $this->belongsTo(ExamShift::class, 'ExamShiftId');
    }
    public function answers()
    {
        return $this->hasMany(TestAnswer::class, 'TestId');
    }
}
