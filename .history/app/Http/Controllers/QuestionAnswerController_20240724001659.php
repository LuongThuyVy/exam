<?php

<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Grade;
use Illuminate\Http\Request;

class QuestionAnswerController extends Controller
{
    public function getSubjects()
    {
        $subjects = Subject::all(['id', 'name']);
        return response()->json($subjects);
    }

    public function getGrades()
    {
        $grades = Grade::all(['id', 'name']);
        return response()->json($grades);
    }

    public function store(Request $request)
    {
        $request->validate([
            'Content' => 'required|string',
            'Difficulty' => 'required|in:Easy,Normal,Hard',
            'OptionA' => 'required|string',
            'OptionB' => 'required|string',
            'OptionC' => 'nullable|string',
            'OptionD' => 'nullable|string',
            'CorrectOption' => 'required|in:A,B,C,D',
            'SubjectGradeId' => 'required|integer|exists:subject_grades,id'
        ]);

        $question = new QuestionAnswer();
        $question->Content = $request->Content;
        $question->Difficulty = $request->Difficulty;
        $question->OptionA = $request->OptionA;
        $question->OptionB = $request->OptionB;
        $question->OptionC = $request->OptionC;
        $question->OptionD = $request->OptionD;
        $question->CorrectOption = $request->CorrectOption;
        $question->SubjectGradeId = $request->SubjectGradeId;
        $question->save();

        return response()->json($question, 201);
    }
}


