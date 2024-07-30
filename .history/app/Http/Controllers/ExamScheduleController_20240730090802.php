<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Examinee;
use App\Models\Test;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ExamScheduleController extends Controller
{
    public function getCurrentExamShifts(Request $request, $accountId)
    {
        {
            // Fetch the Examinee based on AccountId
            $examinee = Examinee::where('AccountId', $accountId)->first();
            
            if (!$examinee) {
                return response()->json(['message' => 'Examinee not found.'], 404);
            }
        
            // Get current time
            $currentTime = Carbon::now();
        
            // Fetch all exam shifts with related exam, subject, and grade information
            $allExamShifts = ExamShift::with(['exam.subjectGrade.subject', 'exam.subjectGrade.grade'])
                ->where('EndTime', '>', $currentTime)
                ->get();
        
            // Fetch exam shifts the examinee has already registered for
            $registeredExamShifts = Test::where('ExamineeId', $examinee->Id)
                ->pluck('ExamShiftId')
                ->toArray();
        
            // Exclude registered exam shifts
            $availableExamShifts = $allExamShifts->filter(function ($examShift) use ($registeredExamShifts) {
                return !in_array($examShift->Id, $registeredExamShifts);
            });
        
            // Format the available exam shifts
            $formattedExamShifts = $availableExamShifts->map(function ($examShift) {
                $exam = $examShift->exam;  // Exam model with additional fields
        
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
                    'eId' => $examShift->ExamId,
                ];
            });
        
            return response()->json($formattedExamShifts->values());
}
