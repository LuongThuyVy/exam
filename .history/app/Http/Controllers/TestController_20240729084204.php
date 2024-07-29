<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Models\Test;
use Carbon\Carbon;

class TestController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'ExamineeId' => 'required|exists:examinees,Id',
                'ExamShiftId' => 'required|exists:exam_shifts,Id',
            ]);
    
            $test = new Test();
            $test->ExamineeId = $validatedData['ExamineeId'];
            $test->ExamShiftId = $validatedData['ExamShiftId'];
            
            if ($test->save()) {
                return response()->json($test, 201);
            } else {
                Log::error('Failed to save test');
                return response()->json(['error' => 'Could not save test'], 500);
            }
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->errors()], 422);
        } catch (QueryException $e) {
            Log::error('Database error: ' . $e->getMessage());
            return response()->json(['error' => 'Database error occurred'], 500);
        } catch (Exception $e) {
            Log::error('Unexpected error: ' . $e->getMessage());
            return response()->json(['error' => 'An unexpected error occurred'], 500);
        }
    }

    
    public function update(Request $request, $id)
    {
        $examResult = Test::find($id);

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
        $question = Test::find($id);
    
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
