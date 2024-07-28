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

    // Nếu bạn không có các trường 'created_at' và 'updated_at'
    public $timestamps = false;

    // Nếu bạn sử dụng một khóa chính khác ngoài 'id'
    // protected $primaryKey = 'your_primary_key';
}