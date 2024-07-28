<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    /**
     * Store a newly created subject in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);

        $subject = Subject::create([
            'name' => $request->name,
        ]);

        return response()->json($subject, 201);
    }

    /**
     * Display a listing of the subjects.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $subjects = Subject::all(['id', 'name']);
        return response()->json($subjects, 200);
    }
}