<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use Carbon\Carbon;

class TestController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'ExamineeId' => 'required|exists:examinees,id',
                'ExamShiftId' => 'required|exists:exam_shifts,id',
            ]);

            $test = new Test();
            $test->ExamineeId = $validatedData['ExamineeId'];
            $test->ExamShiftId = $validatedData['ExamShiftId'];
            $test->save();

            return response()->json($test, 201);
        } catch (Exception $e) {
            Log::error('Error saving test: ' . $e->getMessage());
            return response()->json(['error' => 'Could not save test'], 500);
        }
    }
    public function update(Request $request, $id)
    {
        $examResult = ExamResult::find($id);

        if (!$examResult) {
            return response()->json(['message' => 'Exam result not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'Score' => 'sometimes|numeric',
            'CompletionTime' => 'sometimes|date',
            'ExamineeId' => 'sometimes|integer',
            'ExamShiftId' => 'sometimes|integer'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $examResult->fill($request->only([
            'Score',
            'CompletionTime',
            'ExamineeId',
            'ExamShiftId'
        ]));

        $examResult->save();

        return response()->json([
            'message' => 'Exam result updated successfully',
            'data' => $examResult
        ]);
    }
    public function destroy($id)
    {
        // Tìm bản ghi QuestionAnswer với ID cụ thể
        $question = QuestionAnswer::find($id);
    
        // Kiểm tra nếu bản ghi không tồn tại
        if (!$question) {
            return response()->json(['message' => 'Question not found'], 404);
        }
    
        // Xóa bản ghi
        $question->delete();
    
        // Trả về phản hồi JSON thành công
        return response()->json(['message' => 'Question deleted successfully'], 200);
    }
}
