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
   

}
