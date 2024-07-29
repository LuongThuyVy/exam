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
        // Validate the request data
        $validatedData = $request->validate([
            'ExamineeId' => 'required|exists:accounts,Id',
            'ExamShiftId' => 'required|exists:exam_shifts,Id',
            // 'Score' is optional, default value will be used if not provided
        ]);
    
        // Fetch the Examinee based on Id
        $examinee = Examinee::where('AccountId', $validatedData['ExamineeId'])->first();
        \Log::info('Fetched Examinee:', ['examinee' => $examinee]);
    
        if (!$examinee) {
            // Return error response if Examinee not found
            return response()->json(['message' => 'Examinee not found.'], 404);
        }
    
        // Create a new Test record
        $test = Test::create([
            'ExamineeId' => $examinee->Id,
            'ExamShiftId' => $validatedData['ExamShiftId'],
        ]);
    
        // Return success response with created test data
        return response()->json([
            'message' => 'Test created successfully',
            'test' => $test
        ], 201);
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

    public function getExamShiftsByExamineeId($accountId)
    {
        // Fetch the examinee based on the account ID
        $examinee = Examinee::where('AccountId', $accountId)->first();

        if (!$examinee) {
            return response()->json(['message' => 'Examinee not found'], 404);
        }

        // Fetch all tests associated with the examinee
        $tests = Test::where('ExamineeId', $examinee->Id)->get();

        if ($tests->isEmpty()) {
            return response()->json(['message' => 'No tests found for the examinee'], 404);
        }

        // Collect exam shift IDs from the tests
        $examShiftIds = $tests->pluck('ExamShiftId')->toArray();

        // Fetch the exam shifts based on the collected IDs
        $examineeExamShifts = ExamShift::whereIn('Id', $examShiftIds)->get();

        return response()->json($examineeExamShifts);
    }
}
