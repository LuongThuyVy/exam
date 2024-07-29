<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examinee extends Model
{
    use HasFactory;
    protected $table = 'examinees';
    protected $primaryKey = 'Id';

    protected $fillable = [
        'FullName',
        'Birth',
        'Gender',
        'AddressDetail',
        'AccountId',
        'GradeId',  
    ];

    public $timestamps = false;

    public function account()
    {
        return $this->belongsTo(Account::class, 'AccountId', 'Id');
    }
    
}
