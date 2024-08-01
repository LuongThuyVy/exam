<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;

// class ExamController extends Controller
// {
//     public function index()
//     {
//         $exams = Exam::with(['subjectGrade.subject', 'subjectGrade.grade'])->get();
    
//         $formattedExams = $exams->map(function ($exam) {
//             try {
//                 return $this->formatExam($exam);
//             } catch (\Exception $e) {
//                 \Log::error("Error formatting exam ID {$exam->Id}: " . $e->getMessage());
//                 return null;
//             }
//         })->filter();
    
//         return response()->json($formattedExams);
//     }

//     public function show($id)
//     {
//         $exam = Exam::where("Id", $id)->get();
//         return response()->json($exam);
//     }

//     public function store(Request $request)
//     {
//         // Validate the incoming request
//         $validatedData = $request->validate([
//             'Name' => 'required|string|max:255',
//             'Description' => 'nullable|string',
//             'Duration' => 'required|integer|min:1',
//             'TotalQuestions' => 'required|integer|min:1',
//             'SubjectGradeId' => 'required|exists:subject_grades,Id',
//         ]);

//         // Create a new exam with the validated data
//         $exam = Exam::create($validatedData);
//         // $exam = Exam::create(array_merge($validatedData, ['SubjectGradeId' => $subjectGrade->Id]));
//         // Return a response
//         return response()->json(['message' => 'Exam created successfully', 'exam' => $exam], 201);
//     }

//     public function update(Request $request, $id)
//     {
//         // Validate the incoming request
//         $validatedData = $request->validate([
//             'Name' => 'required|string|max:255',
//             'Description' => 'nullable|string',
//             'Duration' => 'required|integer|min:1',
//             'TotalQuestions' => 'required|integer|min:1',
//             'SubjectGradeId' => 'required|exists:subject_grades,Id',
//         ]);

//         // Find the exam by its ID
//         $exam = Exam::find($id);
//         if (!$exam) {
//             return response()->json(['message' => 'Exam not found'], 404);
//         }

//         // Update the exam with the validated data
//         $exam->update($validatedData);

//         // Return a response
//         return response()->json(['message' => 'Exam updated successfully', 'exam' => $exam], 200);
//     }

//     public function destroy($id)
//     {
//         // Find the exam by its ID
//         $exam = Exam::find($id);
    
//         // Check if the exam exists
//         if (!$exam) {
//             return response()->json(['message' => 'Exam not found'], 404);
//         }
    
//         // Delete the exam
//         $exam->delete();
    
//         // Return a success response
//         return response()->json(['message' => 'Exam deleted successfully'], 200);
//     }

//     private function formatExam($exam)
//     {
//         return [
//             'id' => $exam->Id,
//             'name' => $exam->Name,
//             'description' => $exam->Description,
//             'duration' => $exam->Duration,
//             'totalQuestions' => $exam->TotalQuestions,
//             'subject' => $exam->subjectGrade && $exam->subjectGrade->subject ? [
//                 'id' => $exam->subjectGrade->subject->Id,
//                 'name' => $exam->subjectGrade->subject->Name,
//             ] : null,
//             'grade' => $exam->subjectGrade && $exam->subjectGrade->grade ? [
//                 'id' => $exam->subjectGrade->grade->Id,
//                 'name' => $exam->subjectGrade->grade->Name,
//             ] : null
//         ];
//     }
// }
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
    $exam = Exam::where("Id", $id)->get();
    return response()->json($exam);
}

public function store(Request $request)
{
    // Validate the incoming request
    $validatedData = $request->validate([
        'Name' => 'required|string|max:255',
        'Description' => 'nullable|string',
        'Duration' => 'required|integer|min:1',
        'TotalQuestions' => 'required|integer|min:1',
        'SubjectId' => 'required|integer|exists:subjects,Id',
        'GradeId' => 'required|integer|exists:grades,Id',
    ]);

    // Find or create the SubjectGrade
    $subjectGrade = SubjectGrade::firstOrCreate(
        ['SubjectId' => $request->SubjectId, 'GradeId' => $request->GradeId],
        ['SubjectId' => $request->SubjectId, 'GradeId' => $request->GradeId]
    );

    // Create a new exam with the validated data
    $exam = Exam::create(array_merge($validatedData, ['SubjectGradeId' => $subjectGrade->Id]));

    // Return a response
    return response()->json(['message' => 'Exam created successfully', 'exam' => $exam], 201);
}