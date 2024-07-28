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
            'SubjectId' => 'required|integer',
            'GradeId' => 'required|integer',
        ]);

        $subjectGrade = SubjectGrade::where('SubjectId', $request->SubjectId)
            ->where('GradeId', $request->GradeId)
            ->first();

        if (!$subjectGrade) {
            $subjectGrade = SubjectGrade::create([
                'SubjectId' => $request->SubjectId,
                'GradeId' => $request->GradeId
            ]);
        }

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
        $exams = Exam::with('subjectGrade')->get();
        return response()->json($exams, 200);
    }
}
