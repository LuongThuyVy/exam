<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examinee extends Model
{
    use HasFactory;
    protected $table = 'examinees';

    protected $fillable = [
        'fullname',
        'birth',
        'gender',
        'address_detail',
        'account_id',
        'grade_id',
    ];

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id');
    }
}
