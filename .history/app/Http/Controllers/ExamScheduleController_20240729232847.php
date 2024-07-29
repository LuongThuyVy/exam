<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Examinee;
use App\Models\ExamShift;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ExamScheduleController extends Controller
{
    public function getCurrentExamShifts(Request $request, $accountId)
    {
        // Log the start of the method
        Log::info('Fetching current exam shifts for accountId: ' . $accountId);

        // Get current time
        $currentTime = Carbon::now();
        Log::info('Current time: ' . $currentTime);

        // Fetch the Examinee based on AccountId
        $examinee = Examinee::where('AccountId', $accountId)->first();

        if (!$examinee) {
            Log::warning('Examinee not found for accountId: ' . $accountId);
            return response()->json(['message' => 'Examinee not found.'], 404);
        }

        Log::info('Examinee found: ', ['examineeId' => $examinee->Id]);

        // Fetch all exam shifts where the current time is between StartTime and EndTime
        $currentExamShifts = ExamShift::whereHas('tests', function ($query) use ($examinee) {
            $query->where('ExamineeId', $examinee->Id);
        })
        ->where('StartTime', '<=', $currentTime)
        ->where('EndTime', '>=', $currentTime)
        ->get();

        Log::info('Current exam shifts fetched: ', ['count' => $currentExamShifts->count()]);

        if ($currentExamShifts->isEmpty()) {
            Log::info('No current exam shifts found for accountId: ' . $accountId);
        }

        // Format the response
        $formattedExamShifts = $currentExamShifts->map(function ($shift) {
            return [
                'id' => $shift->Id,
                'name' => $shift->Name,
                'startTime' => $shift->StartTime,
                'endTime' => $shift->EndTime,
                'subjectgrade' => $shift->exam ? [
                    'Id' => $shift->exam->Id,
                    'Name' => $shift->exam->Name,
                    'Description' => $shift->exam->Description,
                    'Duration' => $shift->exam->Duration,
                    'TotalQuestions' => $shift->exam->TotalQuestions,
                    'SubjectGradeId' => $shift->exam->subjectGrade->Id ?? null,
                    'subject_grade' => $shift->exam->subjectGrade ? [
                        'Id' => $shift->exam->subjectGrade->Id,
                        'SubjectId' => $shift->exam->subjectGrade->SubjectId,
                        'GradeId' => $shift->exam->subjectGrade->GradeId,
                        'subject' => $shift->exam->subjectGrade->subject ? [
                            'Id' => $shift->exam->subjectGrade->subject->Id,
                            'Name' => $shift->exam->subjectGrade->subject->Name,
                        ] : null,
                        'grade' => $shift->exam->subjectGrade->grade ? [
                            'Id' => $shift->exam->subjectGrade->grade->Id,
                            'Name' => $shift->exam->subjectGrade->grade->Name,
                        ] : null,
                    ] : null,
                ] : null,
            ];
        });

        return response()->json($formattedExamShifts);
    }
}
