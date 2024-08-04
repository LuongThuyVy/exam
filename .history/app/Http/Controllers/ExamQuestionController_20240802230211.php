<?php

namespace App\Http\Controllers;

use App\Models\ExamQuestion;
use App\Models\ExamShift;
use Illuminate\Http\Request;

class ExamQuestionController extends Controller
{
    public function index($id)
    {
        // Fetch exam questions with related question answers
        $examShift = ExamShift::find($id);
        $examQuestions = ExamQuestion::with('question_answer')->where('ExamId', $examShift->ExamId)->get();
        return response()->json($examQuestions);
    }

    public function ExamDetail($id)
    {
        // Fetch exam questions with related question answers
        $examQuestions = ExamQuestion::with('question_answer')->where('ExamId', $id)->get();
        return response()->json($examQuestions);
    }

    public function store(Request $request)
    {
        $request->validate([
            'Sequence' => 'required|integer',
            'ExamId' => 'required|integer|exists:exams,id',
            'QuestionAnswerId' => 'required|integer|exists:question_answers,id',
        ]);

        // Sử dụng mass assignment để tạo mới
        $examQuestion = ExamQuestion::create($request->only(['Sequence', 'ExamId', 'QuestionAnswerId']));

        return response()->json($examQuestion, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Sequence' => 'required|integer',
            'ExamId' => 'required|integer|exists:exams,id',
            'QuestionAnswerId' => 'required|integer|exists:question_answers,id',
        ]);

        $examQuestion = ExamQuestion::find($id);

        if (!$examQuestion) {
            return response()->json(['message' => 'ExamQuestion not found'], 404);
        }

        // Log dữ liệu trước khi cập nhật
        \Log::info('Updating exam question: ' . json_encode($request->all()));

        // Cập nhật dữ liệu
        $examQuestion->update($request->only(['Sequence', 'ExamId', 'QuestionAnswerId']));

        return response()->json($examQuestion, 200);
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

    public function addQuestions(Request $request)
    {
        $request->validate([
            'examId' => 'required|integer|exists:exams,id',
            'questionIds' => 'required|array',
            'questionIds.*' => 'integer|exists:question_answers,id',
        ]);
    
        $examId = $request->examId;
        $sequence = ExamQuestion::where('ExamId', $examId)->max('Sequence') + 1;
    
        Log::info('Starting to add questions to exam', ['examId' => $examId, 'questionIds' => $request->questionIds]);
    
        foreach ($request->questionIds as $questionId) {
            ExamQuestion::create([
                'Sequence' => $sequence,
                'ExamId' => $examId,
                'QuestionAnswerId' => $questionId
            ]);
    
            Log::info('Added question to exam', ['examId' => $examId, 'questionId' => $questionId, 'sequence' => $sequence]);
    
            $sequence++;
        }
    
        Log::info('Finished adding questions to exam', ['examId' => $examId, 'totalQuestionsAdded' => count($request->questionIds)]);
    
        return response()->json(['message' => 'Questions added successfully'], 201);
    }
}

