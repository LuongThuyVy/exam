<?php

namespace App\Http\Controllers;
use App\Models\Exam;
use App\Models\ExamShift;
use Illuminate\Http\Request;

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
                'subjectgrade'=>  $examShift->exam->subjectGrade,
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
}