<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use Carbon\Carbon;

class TestController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'ExamineeId' => 'required|exists:examinees,id',
                'ExamShiftId' => 'required|exists:exam_shifts,id',
            ]);

            $test = new Test();
            $test->ExamineeId = $validatedData['ExamineeId'];
            $test->ExamShiftId = $validatedData['ExamShiftId'];
            $test->save();

            return response()->json($test, 201);
        } catch (Exception $e) {
            Log::error('Error saving test: ' . $e->getMessage());
            return response()->json(['error' => 'Could not save test'], 500);
        }
    }
}
