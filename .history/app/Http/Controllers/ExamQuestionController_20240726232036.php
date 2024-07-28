<?php

namespace App\Http\Controllers;

use App\Models\ExamQuestion;
use Illuminate\Http\Request;

class ExamQuestionController extends Controller
{
    public function index($examId)
    {
        $examQuestions = ExamQuestion::where('ExamId', $examId)->get();
        return response()->json($examQuestions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'Sequence' => 'required|integer',
            'ExamId' => 'required|integer|exists:exams,id',
            'QuestionAnswerId' => 'required|integer|exists:question_answers,id',
        ]);

        $examQuestion = ExamQuestion::create($request->all());

        return response()->json($examQuestion, 201);
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'Name' => 'required|string|max:255',
        'Description' => 'nullable|string',
        'Duration' => 'required|integer',
        'TotalQuestions' => 'required|integer',
        'SubjectId' => 'required|integer|exists:subjects,id',
        'GradeId' => 'required|integer|exists:grades,id',
    ]);

    $exam = Exam::find($id);

    if (!$exam) {
        return response()->json(['message' => 'Exam not found'], 404);
    }

    $subjectGrade = SubjectGrade::where('SubjectId', $request->SubjectId)
        ->where('GradeId', $request->GradeId)
        ->first();

    if ($subjectGrade) {
        $subjectGradeId = $subjectGrade->Id;
    } else {
        $newSubjectGrade = SubjectGrade::create([
            'SubjectId' => $request->SubjectId,
            'GradeId' => $request->GradeId,
        ]);
        $subjectGradeId = $newSubjectGrade->Id;
    }

    $exam->Name = $request->input('Name');
    $exam->Description = $request->input('Description');
    $exam->Duration = $request->input('Duration');
    $exam->TotalQuestions = $request->input('TotalQuestions');
    $exam->SubjectGradeId = $subjectGradeId;
    $exam->save();

    return response()->json($exam, 200);
}

    
    public function destroy($id)
    {
        $examQuestion = ExamQuestion::find($id);
    
        if (!$examQuestion) {
            return response()->json(['message' => 'ExamQuestion not found'], 404);
        }
    
        // Log dữ liệu trước khi xóa
        \Log::info('Deleting exam question: ' . $id);
    
        $examQuestion->delete();
    
        return response()->json(['message' => 'ExamQuestion deleted successfully'], 200);
    }
    
}
