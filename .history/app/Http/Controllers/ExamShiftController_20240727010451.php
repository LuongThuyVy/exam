<?php

namespace App\Http\Controllers;

use App\Models\ExamShift;
use App\Models\Exam;
use Illuminate\Http\Request;

class ExamShiftController extends Controller
{
    public function index()
    {
        $examShifts = ExamShift::with('exam')->get(); // Ensure `exam` relationship is defined in `ExamShift` model
        return response()->json($examShifts);
    }

    public function store(Request $request)
    {
        $request->validate([
            'Name' => 'required|string|max:255',
            'StartTime' => 'required|date_format:Y-m-d H:i:s',
            'EndTime' => 'required|date_format:Y-m-d H:i:s',
            'ExamId' => 'required|integer|exists:exams,id',
        ]);

        $examShift = ExamShift::create($request->all());
        return response()->json($examShift, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'Name' => 'required|string|max:255',
            'StartTime' => 'required|date_format:Y-m-d H:i:s',
            'EndTime' => 'required|date_format:Y-m-d H:i:s',
            'ExamId' => 'required|integer|exists:exams,id',
        ]);

        $examShift = ExamShift::find($id);

        if (!$examShift) {
            return response()->json(['message' => 'ExamShift not found'], 404);
        }

        $examShift->update($request->all());
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
