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
        'createdate',
        'roleid',
    ];
    protected $hidden = [
        'password', 'remember_token',
    ];
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
