<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionAnswer; // Import model QuestionAnswer
use App\Models\Subject;
use App\Models\Grade;
use App\Models\SubjectGrade; 

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

        // Tạo một SubjectGrade nếu nó chưa tồn tại
        $subjectGrade = SubjectGrade::firstOrCreate([
            'SubjectId' => $request->input('SubjectId'),
            'GradeId' => $request->input('GradeId'),
        ]);

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
