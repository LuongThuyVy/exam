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
        'QuestionAnswerId',
        'CompletionTime'
    ];
    public $timestamps = false;

    public function test()
    {
        return $this->belongsTo(Test::class, 'TestId', 'Id');
    }
    public function questionAnswer()
    {
        return $this->belongsTo(QuestionAnswer::class, 'QuestionAnswerId', 'Id');
    }
}
