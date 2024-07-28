<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    // Tên bảng
    protected $table = 'subjects';

    // Các trường có thể điền
    protected $fillable = ['name'];

    
    public $timestamps = false;

}