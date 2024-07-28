<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with(['subjectGrade.subject', 'subjectGrade.grade'])->get();

        $formattedExams = $exams->map(function ($exam) {
            return [
                'id' => $exam->Id,
                'name' => $exam->Name,
                'description' => $exam->Description,
                'duration' => $exam->Duration,
                'totalQuestions' => $exam->TotalQuestions,
                'subject' => $exam->subjectGrade->subject ? [
                    'id' => $exam->subjectGrade->subject->Id,
                    'name' => $exam->subjectGrade->subject->Name,
                ] : null,
                'grade' => $exam->subjectGrade->grade ? [
                    'id' => $exam->subjectGrade->grade->Id,
                    'name' => $exam->subjectGrade->grade->Name,
                ] : null
            ];
        });

        return response()->json($formattedExams);
    }

    public function show($id)
    {
        $exam = Exam::with(['subjectGrade.subject', 'subjectGrade.grade'])->findOrFail($id);

        $formattedExam = [
            'id' => $exam->Id,
            'name' => $exam->Name,
            'description' => $exam->Description,
            'duration' => $exam->Duration,
            'totalQuestions' => $exam->TotalQuestions,
            'subject' => $exam->subjectGrade->subject ? [
                'id' => $exam->subjectGrade->subject->Id,
                'name' => $exam->subjectGrade->subject->Name,
            ] : null,
            'grade' => $exam->subjectGrade->grade ? [
                'id' => $exam->subjectGrade->grade->Id,
                'name' => $exam->subjectGrade->grade->Name,
            ] : null
        ];

        return response()->json($formattedExam);
    }
}