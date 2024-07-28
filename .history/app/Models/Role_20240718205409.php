<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    // Specify the table name if it's different from the model name
    protected $table = 'roles';

    // Define the fillable attributes for mass assignment
    protected $fillable = ['Name'];

    // Disable the timestamps if the table doesn't have 'created_at' and 'updated_at' columns
    public $timestamps = false;
    public function accounts()
    {
        return $this->hasMany(Account::class, 'role_id');
    }
}