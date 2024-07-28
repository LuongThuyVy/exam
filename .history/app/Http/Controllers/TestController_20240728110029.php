<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use Carbon\Carbon;

class TestController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ExamineeId' => 'required|exists:examinees,id',
            'ExamShiftId' => 'required|exists:exam_shifts,id',
        ]);

        $test = new Test();
        $test->ExamineeId = $validatedData['ExamineeId'];
        $test->ExamShiftId = $validatedData['ExamShiftId'];
        $test->Score = 0;
        $test->CompletionTime = null;
        $test->save();

        return response()->json($test, 200);
    }
}
