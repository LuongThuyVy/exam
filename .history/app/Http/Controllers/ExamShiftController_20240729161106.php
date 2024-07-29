<?php

namespace App\Http\Controllers;
use App\Models\Exam;
use App\Models\ExamShift;
use App\Models\Examinee;
use Illuminate\Http\Request;
use Carbon\Carbon;



use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\ExamShift;
use App\Models\Examinee;
use Carbon\Carbon;

class ExamShiftController extends Controller
{
    public function index()
    {
        $examShifts = ExamShift::with(['exam.subjectGrade.subject', 'exam.subjectGrade.grade'])->get();

        $formattedExamShifts = $examShifts->map(function ($examShift) {
            return [
                'id' => $examShift->Id,
                'name' => $examShift->Name,
                'startTime' => $examShift->StartTime,
                'endTime' => $examShift->EndTime,
                // 'subject' => $examShift->exam && $examShift->exam->SubjectGrade && $examShift->exam->SubjectGrade->subject ? [
                //     'id' => $examShift->exam->SubjectGrade->subject->Id,
                //     'name' => $examShift->exam->SubjectGrade->subject->Name,
                // ] : null,
                // 'grade' => $examShift->exam && $examShift->exam->subjectGrade && $examShift->exam->subjectGrade->grade ? [
                //     'id' => $examShift->exam->subjectGrade->grade->Id,
                //     'name' => $examShift->exam->subjectGrade->grade->Name,
                // ] : null,
                'subjectgrade'=>  $examShift->exam,
                'eId ' =>  $examShift-> ExamId
            ];
        });

        return response()->json($formattedExamShifts);
    }

    public function show($id)
    {
        $examShift = ExamShift::with(['exam.subjectGrade.subject', 'exam.subjectGrade.grade'])->find($id);
        if (!$examShift) {
            return response()->json(['message' => 'Exam Shift not found'], 404);
        }

        $formattedExamShift = [
            'id' => $examShift->Id,
            'name' => $examShift->Name,
            'startTime' => $examShift->StartTime,
            'endTime' => $examShift->EndTime,
            'subject' => $examShift->exam && $examShift->exam->subjectGrade && $examShift->exam->subjectGrade->subject ? [
                'id' => $examShift->exam->subjectGrade->subject->Id,
                'name' => $examShift->exam->subjectGrade->subject->Name,
            ] : null,
            'grade' => $examShift->exam && $examShift->exam->subjectGrade && $examShift->exam->subjectGrade->grade ? [
                'id' => $examShift->exam->subjectGrade->grade->Id,
                'name' => $examShift->exam->subjectGrade->grade->Name,
            ] : null
        ];

        return response()->json($formattedExamShift);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Name' => 'required|string|max:20',
            'StartTime' => 'required|date',
            'EndTime' => 'required|date|after:StartTime',
            'ExamId' => 'required|integer|exists:exams,Id',
        ]);

        $examShift = ExamShift::create($validatedData);
        return response()->json($examShift, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'Name' => 'string|max:20',
            'StartTime' => 'date',
            'EndTime' => 'date|after:StartTime',
            'ExamId' => 'integer|exists:exams,Id',
        ]);

        $examShift = ExamShift::find($id);
        if (!$examShift) {
            return response()->json(['message' => 'ExamShift not found'], 404);
        }

        $examShift->update($validatedData);
        return response()->json($examShift, 200);
    }

    public function destroy($id)
    {
        $examShift = ExamShift::find($id);
        if (!$examShift) {
            return response()->json(['message' => 'ExamShift not found'], 404);
        }

        $examShift->delete();
        return response()->json(['message' => 'ExamShift deleted successfully'], 200);
    }

    public function getAvailableExamShifts(Request $request, $accountId)
    {
        // Fetch the Examinee based on AccountId
        $examinee = Examinee::where('AccountId', $accountId)->first();
        
        if (!$examinee) {
            return response()->json(['message' => 'Examinee not found.'], 404);
        }

        // Get current time
        $currentTime = Carbon::now();

        // Fetch all exam shifts
        $allExamShifts = ExamShift::where('EndTime', '>', $currentTime)->get();

        // Fetch exam shifts the examinee has already registered for
        $registeredExamShifts = Test::where('ExamineeId', $examinee->Id)
            ->pluck('ExamShiftId')
            ->toArray();

        // Exclude registered exam shifts
        $availableExamShifts = $allExamShifts->filter(function ($examShift) use ($registeredExamShifts) {
            return !in_array($examShift->Id, $registeredExamShifts);
        });

        return response()->json($availableExamShifts->values());
    }
}