<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examinee extends Model
{
    use HasFactory;
    protected $table = 'examinees';

    protected $fillable = [
        'FullName',
        'Birth',
        'Gender',
        'AddressDetail',
        'AccountId',
        'radeid',
    ];

    public $timestamps = false;

    public function account()
    {
        return $this->belongsTo(Account::class, 'id');
    }
}
