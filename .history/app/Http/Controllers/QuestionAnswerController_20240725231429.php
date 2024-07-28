<?php
namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Grade;
use App\Models\SubjectGrade;
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
            'SubjectId' => 'required|integer|exists:subjects,id',
            'GradeId' => 'required|integer|exists:grades,id',
        ]);

        // Tìm SubjectGradeId dựa trên SubjectId và GradeId
        $subjectGrade = SubjectGrade::where('SubjectId', $request->input('SubjectId'))
                                    ->where('GradeId', $request->input('GradeId'))
                                    ->first();

        if (!$subjectGrade) {
            return response()->json(['message' => 'Invalid SubjectId or GradeId combination'], 422);
        }

        $question = new QuestionAnswer();
        $question->Content = $request->input('Content');
        $question->Difficulty = $request->input('Difficulty');
        $question->OptionA = $request->input('OptionA');
        $question->OptionB = $request->input('OptionB');
        $question->OptionC = $request->input('OptionC');
        $question->OptionD = $request->input('OptionD');
        $question->CorrectOption = $request->input('CorrectOption');
        $question->SubjectGradeId = $subjectGrade->id;
        $question->save();

        return response()->json($question, 201);
    }
}
