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
    
      
    public function show($id)
    {
        // Fetch the test by its ID, including related data
        $test = Test::with(['examinee', 'examShift', 'answers','answers.questionAnswer'])->find($id);

        if (!$test) {
            return response()->json(['message' => 'Test not found'], 404);
        }

        return response()->json([
            'message' => 'Test fetched successfully',
            'test' => $test
        ]);
    }

    public function getAll()
    {
        // Fetch all tests, including related data
        $tests = Test::with(['examinee', 'examShift', 'answers'])->get();

        return response()->json([
            'message' => 'All tests fetched successfully',
            'tests' => $tests
        ]);
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

    public function getCurrentExamShifts(Request $request, $accountId)
    {

        // Fetch the Examinee based on AccountId
        $examinee = Examinee::where('AccountId', $accountId)->first();

        if (!$examinee) {
            Log::error('Examinee not found', ['accountId' => $accountId]);
            return response()->json(['message' => 'Examinee not found.'], 404);
        }

   
        $pendingTests = Test::where('ExamineeId', $examinee->Id)
            ->with(['examShift' => function ($query) {
                $query->with(['exam.subjectGrade.subject', 'exam.subjectGrade.grade']);
            }])
            ->get();

        // Format the pending tests
        $formattedPendingTests = $pendingTests->map(function ($test) {
            $examShift = $test->examShift;
            $exam = $examShift->exam;

            return [
                'testId' => $test->Id,
                'examineeId' => $test->ExamineeId,
                'examShift' => [

                    'id' => $examShift->Id,
                    'score' => $test->Score,
                    'time' => $test->CompletionTime,
                    'name' => $examShift->Name,
                    'startTime' => $examShift->StartTime,
                    'endTime' => $examShift->EndTime,
                    'subjectgrade' => $exam ? [
                        'Id' => $exam->Id,
                        'Name' => $exam->Name,
                        'Description' => $exam->Description,
                        'Duration' => $exam->Duration,
                        'TotalQuestions' => $exam->TotalQuestions,
                        'SubjectGradeId' => $exam->subjectGrade->Id ?? null,
                        'subject_grade' => $exam->subjectGrade ? [
                            'Id' => $exam->subjectGrade->Id,
                            'SubjectId' => $exam->subjectGrade->SubjectId,
                            'GradeId' => $exam->subjectGrade->GradeId,
                            'subject' => $exam->subjectGrade->subject ? [
                                'Id' => $exam->subjectGrade->subject->Id,
                                'Name' => $exam->subjectGrade->subject->Name,
                            ] : null,
                            'grade' => $exam->subjectGrade->grade ? [
                                'Id' => $exam->subjectGrade->grade->Id,
                                'Name' => $exam->subjectGrade->grade->Name,
                            ] : null,
                        ] : null,
                    ] : null,
                ]
            ];
        });

        return response()->json($formattedPendingTests);
    }
}
