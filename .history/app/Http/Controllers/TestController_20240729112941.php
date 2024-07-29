<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Validator;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Examinee;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class TestController extends Controller
{
 
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ExamineeId' => 'required|exists:examinees,Id',
            'ExamShiftId' => 'required|exists:exam_shifts,Id',
        ]);
$examinee = Examinee::where('AccountId', $request->Ex)
        $test = Test::create([
            'ExamineeId' => $validatedData['ExamineeId'],
            'ExamShiftId' => $validatedData['ExamShiftId'],
            'Score' => $validatedData['Score'] ?? 0,
        ]);

        return response()->json(['message' => 'Test created successfully', 'test' => $test], 201);
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
