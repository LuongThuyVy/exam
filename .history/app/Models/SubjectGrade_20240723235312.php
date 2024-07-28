<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubjectGrade extends Model
{
    use HasFactory;
    protected $table = 'subject_grades';

    protected $fillable = [
        'SubjectId',
        'GradeId'
    ];

    public $timestamps = false;

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'SubjectId', 'Id');
    }

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'GradeId', 'Id');
    }
}
