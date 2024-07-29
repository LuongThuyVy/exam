<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $table = 'subjects';
    protected $primaryKey = 'Id';

    protected $fillable = [
        'name'
    ];

    public $timestamps = false;

    public function subjectGrades()
    {
        return $this->hasMany(SubjectGrade::class, 'SubjectId');
    }
}
