<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $table = 'accounts';

    protected $fillable = [
        'email',
        'phone',
        'password',
        'lockenable',
        'avatar',
        'createdate',
        'roleid',
    ];
    [2024-07-18 15:06:48] local.INFO: Hashed Password: $2y$10$dV0W/J1pZ4HS/hzIDWcXEOPPE/YKiXmCAfaOiWa3FyjpXFcHh3lRS  
[2024-07-18 15:06:54] local.INFO: Input Password: 123123123  
[2024-07-18 15:06:54] local.INFO: Stored Hashed Password:  
    public $timestamps = false;

    public function role()
    {
        return $this->belongsTo(Role::class, 'roleid');
    }

    public function examinee()
    {
        return $this->hasOne(Examinee::class, 'AccountId');
    }
}
