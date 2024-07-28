<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamShift extends Model
{
    use HasFactory;

    // Chỉ định tên bảng nếu khác tên mặc định
    protected $table = 'exam_shifts';

    // Chỉ định các thuộc tính có thể gán hàng loạt (mass assignable)
    protected $fillable = [
        'Id',
        'Name',
        'StartTime',
        'EndTime',
        'ExamId',
    ];

    public $timestamps = false;

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'ExamId');
    }   
}
