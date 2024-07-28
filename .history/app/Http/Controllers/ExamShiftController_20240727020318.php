<?php

namespace App\Http\Controllers;

use App\Models\ExamShift;
use Illuminate\Http\Request;

class ExamShiftController extends Controller
{
    public function index()
    {
        // Fetch all exam shifts with their related exams
        $examShifts = ExamShift::with(['exam.subject', 'exam.grade'])->get();

        return response()->json($examShifts);
    }

    public function show($id)
    {
        // Fetch a single exam shift with its related exam
        $examShift = ExamShift::with('exam.subject', 'exam.grade')->find($id);

        if (!$examShift) {
            return response()->json(['message' => 'Exam Shift not found'], 404);
        }

        return response()->json($examShift);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Name' => 'required|string|max:20',
            'StartTime' => 'required|date',
            'EndTime' => 'required|date|after:StartTime',
            'ExamId' => 'required|integer|exists:exams,id',
        ]);

        $examShift = ExamShift::create($validatedData);

        return response()->json($examShift, 201);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'Name' => 'required|string|max:20',
            'StartTime' => 'required|date',
            'EndTime' => 'required|date|after:StartTime',
            'ExamId' => 'required|integer|exists:exams,id',
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

    $examShifts = ExamShift::with('exam')->get();
foreach ($examShifts as $shift) {
    echo $shift->exam; // Kiểm tra xem dữ liệu exam có tồn tại không
}



