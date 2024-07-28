<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestAnswer extends Model
{
    use HasFactory;

    protected $table = 'test_answers';
    protected $fillable = [
        'Id',
        'SelectedOption',
        'IsCorrect',
        'TestId',
        'QuestionAnsweredId',
    ];
    public $timestamps = false;
    public function answers()
    {
        return $this->hasMany(TestAnswer::class, 'TestId');
    }

}
