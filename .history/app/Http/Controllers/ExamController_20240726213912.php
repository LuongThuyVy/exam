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

        $subjectGrade = SubjectGrade::where('SubjectId', $request->SubjectId)
            ->where('GradeId', $request->GradeId)
            ->first();

        if ($subjectGrade) {
            $id = $subjectGrade->Id;
        } else {
            $newSubjectGrade = SubjectGrade::create([
                'SubjectId' => $request->SubjectId,
                'GradeId' => $request->GradeId,
            ]);
            $id = $newSubjectGrade->Id;
        }

        $exam = new Exam();
        $exam->Name = $request->input('Name');
        $exam->Description = $request->input('Description');
        $exam->Duration = $request->input('Duration');
        $exam->TotalQuestions = $request->input('TotalQuestions');
        $exam->SubjectGradeId = $id;
        $exam->save();

        return response()->json($exam, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Name' => 'required|string|max:255',
            'Description' => 'nullable|string',
            'Duration' => 'required|integer',
            'TotalQuestions' => 'required|integer',
            'SubjectId' => 'required|integer|exists:subjects,id',
            'GradeId' => 'required|integer|exists:grades,id',
        ]);

        $exam = Exam::find($id);

        if (!$exam) {
            return response()->json(['message' => 'Exam not found'], 404);
        }

        $subjectGrade = SubjectGrade::where('SubjectId', $request->SubjectId)
            ->where('GradeId', $request->GradeId)
            ->first();

        if ($subjectGrade) {
            $subjectGradeId = $subjectGrade->Id;
        } else {
            $newSubjectGrade = SubjectGrade::create([
                'SubjectId' => $request->SubjectId,
                'GradeId' => $request->GradeId,
            ]);
            $subjectGradeId = $newSubjectGrade->Id;
        }

        $exam->Name = $request->input('Name');
        $exam->Description = $request->input('Description');
        $exam->Duration = $request->input('Duration');
        $exam->TotalQuestions = $request->input('TotalQuestions');
        $exam->SubjectGradeId = $subjectGradeId;
        $exam->save();

        return response()->json($exam, 200);
    }

}
