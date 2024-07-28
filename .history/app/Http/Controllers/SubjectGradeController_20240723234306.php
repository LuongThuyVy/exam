<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubjectGrade;

class SubjectGradeController extends Controller
{
    public function index()
    {
        $subjectGrades = SubjectGrade::with(['subject', 'grade'])->get();
        return response()->json($subjectGrades, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'SubjectId' => 'required|integer|exists:subjects,id',
            'GradeId' => 'required|integer|exists:grades,id'
        ]);

        $subjectGrade = SubjectGrade::create([
            'SubjectId' => $request->SubjectId,
            'GradeId' => $request->GradeId
        ]);

        return response()->json($subjectGrade->load(['subject', 'grade']), 201);
    }

    public function show($id)
    {
        $subjectGrade = SubjectGrade::with(['subject', 'grade'])->find($id);
        if (!$subjectGrade) {
            return response()->json(['message' => 'Not Found'], 404);
        }
        return response()->json($subjectGrade, 200);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'SubjectId' => 'required|integer|exists:subjects,id',
            'GradeId' => 'required|integer|exists:grades,id'
        ]);

        $subjectGrade = SubjectGrade::find($id);
        if (!$subjectGrade) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $subjectGrade->update([
            'SubjectId' => $request->SubjectId,
            'GradeId' => $request->GradeId
        ]);

        return response()->json($subjectGrade->load(['subject', 'grade']), 200);
    }

    public function destroy($id)
    {
        $subjectGrade = SubjectGrade::find($id);
        if (!$subjectGrade) {
            return response()->json(['message' => 'Not Found'], 404);
        }

        $subjectGrade->delete();
        return response()->json(['message' => 'Deleted'], 200);
    }
}
