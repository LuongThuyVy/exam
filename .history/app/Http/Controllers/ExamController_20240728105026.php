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
            try {
                return $this->formatExam($exam);
            } catch (\Exception $e) {
                \Log::error("Error formatting exam ID {$exam->Id}: " . $e->getMessage());
                return null;
            }
        })->filter();
    
        return response()->json($formattedExams);
    }

    public function show($id)
    {
        $exam = Exam::where("ID",  $id)->get()
        return response()->json($exam );
    }

    private function formatExam($exam)
    {
        return [
            'id' => $exam->Id,
            'name' => $exam->Name,
            'description' => $exam->Description,
            'duration' => $exam->Duration,
            'totalQuestions' => $exam->TotalQuestions,
            'subject' => $exam->subjectGrade && $exam->subjectGrade->subject ? [
                'id' => $exam->subjectGrade->subject->Id,
                'name' => $exam->subjectGrade->subject->Name,
            ] : null,
            'grade' => $exam->subjectGrade && $exam->subjectGrade->grade ? [
                'id' => $exam->subjectGrade->grade->Id,
                'name' => $exam->subjectGrade->grade->Name,
            ] : null
        ];
    }
}