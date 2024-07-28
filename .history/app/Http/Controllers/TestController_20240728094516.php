<?php
namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\Http\Request;

class TestController extends Controller
{
    // Phương thức để lấy tất cả các bài thi
    public function index()
    {
        $tests = Test::with(['examinee', 'examShift'])->get();
        return response()->json($tests);
    }

    // Phương thức để tạo bài thi mới
    public function store(Request $request)
    {
        $request->validate([
            'Score' => 'required|numeric',
            'CompletionTime' => 'required|date',
            'ExamineeId' => 'required|exists:examinees,Id',
            'ExamShiftId' => 'required|exists:exam_shifts,Id'
        ]);

        $test = Test::create($request->all());

        return response()->json($test, 201);
    }

    // Phương thức để lấy bài thi theo ID
    public function show($id)
    {
        $test = Test::with(['examinee', 'examShift'])->find($id);

        if (!$test) {
            return response()->json(['message' => 'Test not found'], 404);
        }

        return response()->json($test);
    }
}
