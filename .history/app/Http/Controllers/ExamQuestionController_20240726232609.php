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
}

