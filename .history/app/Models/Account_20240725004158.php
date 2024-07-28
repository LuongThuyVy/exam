<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;
    protected $table = 'accounts';

    protected $fillable = [
        'Email',
        'Phone',
        'Password',
        'LockEnable',
        'CreateDate',
        'RoleId',
    ];
    protected $hidden = [
        'Password', 'remember_token',
    ];
    public $timestamps = false;

    public function role()
    {
        return $this->belongsTo(Role::class, 'RoleId');
    }

    public function examinee()
    {
        return $this->hasOne(Examinee::class, 'AccountId','Id');
    }
}
