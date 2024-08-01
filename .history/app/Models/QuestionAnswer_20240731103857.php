    <?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class QuestionAnswer extends Model
    {
        use HasFactory;

        protected $table = 'question_answers';
        protected $primaryKey = 'Id';

        protected $fillable = [
            'Content',
            'Difficulty',
            'OptionA',
            'OptionB',
            'OptionC',
            'OptionD',
            'CorrectOption',
            'SubjectGradeId',
        ];

        public $timestamps = false; 

        public function subject_grade()
        {
            return $this->belongsTo(SubjectGrade::class, 'SubjectGradeId', 'Id');
        }

    }


