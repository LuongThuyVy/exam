<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\Subject;
use App\Models\Grade;
use App\Models\SubjectGrade;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'Name' => 'required|string|max:255',
            'Description' => 'nullable|string',
            'Duration' => 'required|integer',
            'TotalQuestions' => 'required|integer',
            'SubjectId' => 'required|integer|exists:subjects,id',
            'GradeId' => 'required|integer|exists:grades,id',
        ]);

        $subjectGrade = SubjectGrade::firstOrCreate(
            [
                'SubjectId' => $request->SubjectId,
                'GradeId' => $request->GradeId
            ],
            [
                'SubjectId' => $request->SubjectId,
                'GradeId' => $request->GradeId
            ]
        );

        $exam = Exam::create([
            'Name' => $request->Name,
            'Description' => $request->Description,
            'Duration' => $request->Duration,
            'TotalQuestions' => $request->TotalQuestions,
            'SubjectGradeId' => $subjectGrade->id,
        ]);

        return response()->json($exam, 201);
    }

    public function index()
    {
        $exams = Exam::with(['subjectGrade.subject', 'subjectGrade.grade'])->get();
        return response()->json($exams, 200);
    }
}
