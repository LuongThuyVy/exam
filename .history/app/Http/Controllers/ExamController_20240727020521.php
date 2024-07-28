namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable = ['Name', 'Description', 'Duration', 'TotalQuestions', 'SubjectGradeId'];

    // Define the relationship with the SubjectGrade model
    public function subjectGrade()
    {
        return $this->belongsTo(SubjectGrade::class, 'SubjectGradeId');
    }

    // Define the relationship with the Subject model through SubjectGrade
    public function subject()
    {
        return $this->hasOneThrough(
            Subject::class,
            SubjectGrade::class,
            'Id', // Foreign key on SubjectGrade table
            'Id', // Foreign key on Subject table
            'SubjectGradeId', // Local key on Exam table
            'SubjectId' // Local key on SubjectGrade table
        );
    }

    // Define the relationship with the Grade model through SubjectGrade
    public function grade()
    {
        return $this->hasOneThrough(
            Grade::class,
            SubjectGrade::class,
            'Id', // Foreign key on SubjectGrade table
            'Id', // Foreign key on Grade table
            'SubjectGradeId', // Local key on Exam table
            'GradeId' // Local key on SubjectGrade table
        );
    }
}
