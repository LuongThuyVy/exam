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

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function examinee()
    {
        return $this->hasOne(Examinee::class, 'account_id');
    }
}
