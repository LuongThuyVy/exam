<?php

namespace App\Http\Controllers;
use App\Models\QuestionAnswer;
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
            'SubjectId' => 'required|integer',
            'GradeId' => 'required|integer',
        ]);

        $subjectGrade = SubjectGrade::where('SubjectId', $request->SubjectId)
        ->where('GradeId', $request->GradeId)
        ->first();

    if ($subjectGrade) {
        // Nếu đã tồn tại, lấy id của bản ghi đó
        $id = $subjectGrade->Id;
      
    }else {
        // Nếu chưa tồn tại, tạo mới và lấy id của bản ghi mới
        $newSubjectGrade = SubjectGrade::create([   
            'SubjectId' => $request->SubjectId,
            'GradeId' => $request->GradeId
        ]);
    $id = $newSubjectGrade->Id;
    }
        $question = new QuestionAnswer();
        $question->Content = $request->input('Content');
        $question->Difficulty = $request->input('Difficulty');
        $question->OptionA = $request->input('OptionA');
        $question->OptionB = $request->input('OptionB');
        $question->OptionC = $request->input('OptionC');
        $question->OptionD = $request->input('OptionD');
        $question->CorrectOption = $request->input('CorrectOption');
        $question->SubjectGradeId = $id;
        $question->save();
    
        return response()->json($question, 201);
    }
}    


