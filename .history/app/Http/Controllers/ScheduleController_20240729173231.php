<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\ExamShift;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index($accountId)
    {
        // Fetch the exam shifts associated with the given accountId
        $examShiftIds = Test::where('ExamineeId', $accountId)
            ->pluck('ExamShiftId')
            ->toArray();

        if (empty($examShiftIds)) {
            return response()->json(['message' => 'No exam shifts found for this account.'], 404);
        }

        // Fetch the exam shifts with their related exam, subject, and grade information
        $examShifts = ExamShift::with(['exam.subjectGrade.subject', 'exam.subjectGrade.grade'])
            ->whereIn('Id', $examShiftIds)
            ->get();

        if ($examShifts->isEmpty()) {
            return response()->json(['message' => 'No exam shifts found.'], 404);
        }

        // Format the exam shifts
        $formattedExamShifts = $examShifts->map(function ($examShift) {
            $exam = $examShift->exam; // Exam model with additional fields

            return [
                'id' => $examShift->Id,
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
            ];
        });

        return response()->json($formattedExamShifts);
    }
}
