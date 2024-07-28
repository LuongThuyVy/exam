<?php

namespace App\Http\Controllers;
use App\Models\Grade;
use Illuminate\Http\Request;

class GradeController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);

        $grade = Grade::create([
            'name' => $request->name,
        ]);

        return response()->json($grade, 201);
    }


    public function index()
    {
        $grades = Grade::all(['id', 'name']);
        return response()->json($grades, 200);
    }
}
