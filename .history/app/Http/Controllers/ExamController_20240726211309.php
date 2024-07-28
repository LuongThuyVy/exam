<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;

class ExamController extends Controller
{
    public function index()
    {
        $exams = Exam::with(['subject', 'grade'])->get();
        return response()->json($exams);
    }

    public function show($id)
    {
        $exam = Exam::with(['subject', 'grade'])->findOrFail($id);
        return response()->json($exam);
    }

    public function store(Request $request)
    {
        $request->validate([
            'Name' => 'required|string|max:255',
            'Description' => 'required|string',
            'Duration' => 'required|integer',
            'TotalQuestions' => 'required|integer',
            'SubjectId' => 'required|integer|exists:subjects,id',
            'GradeId' => 'required|integer|exists:grades,id',
        ]);

        $exam = Exam::create($request->all());
        return response()->json($exam, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Name' => 'string|max:255',
            'Description' => 'string',
            'Duration' => 'integer',
            'TotalQuestions' => 'integer',
            'SubjectId' => 'integer|exists:subjects,id',
            'GradeId' => 'integer|exists:grades,id',
        ]);

        $exam = Exam::findOrFail($id);
        $exam->update($request->all());
        return response()->json($exam);
    }

    public function destroy($id)
    {
        $exam = Exam::findOrFail($id);
        $exam->delete();
        return response()->json(null, 204);
    }
}
