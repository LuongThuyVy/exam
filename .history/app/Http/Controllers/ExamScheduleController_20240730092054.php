<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Examinee;
use App\Models\Test;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ExamScheduleController extends Controller
{
    public function getCurrentExamShifts(Request $request, $accountId, $date)
    {
        // Convert the provided date to a Carbon instance
        $date = Carbon::parse($date);

        // Fetch the Examinee based on AccountId
        $examinee = Examinee::where('AccountId', $accountId)->first();

        if (!$examinee) {
            Log::error('Examinee not found', ['accountId' => $accountId]);
            return response()->json(['message' => 'Examinee not found.'], 404);
        }

        // Fetch all tests for the examinee where completion time is null
        $pendingTests = Test::where('ExamineeId', $examinee->Id)
            ->whereNull('CompletionTime')
            ->whereHas('examShift', function ($query) use ($date) {
                $query->where('StartTime', '<=', $date)
                      ->where('EndTime', '>=', $date);
            })
            ->with(['examShift' => function ($query) {
                $query->with(['exam.subjectGrade.subject', 'exam.subjectGrade.grade']);
            }])
            ->get();

        // Format the pending tests
        $formattedPendingTests = $pendingTests->map(function ($test) {
            $examShift = $test->examShift;
            $exam = $examShift->exam;

            return [
                'time' => Carbon::now()->format('Y-m-d H:i:s'),
                'testId' => $test->Id,
                'examineeId' => $test->ExamineeId,
                'examShift' => [
                    'id' => $examShift->Id,
                    'name' => $examShift->Name,
                    'startTime' => $examShift->StartTime->format('Y-m-d H:i:s'),
                    'endTime' => $examShift->EndTime->format('Y-m-d H:i:s'),
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
