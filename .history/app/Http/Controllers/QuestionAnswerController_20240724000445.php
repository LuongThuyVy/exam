<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\QuestionAnswer;

class QuestionAnswerController extends Controller
{
    /**
     * Store a newly created question in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'Content' => 'required|string',
            'Difficulty' => 'required|in:Easy,Normal,Hard',
            'OptionA' => 'required|string',
            'OptionB' => 'required|string',
            'OptionC' => 'nullable|string',
            'OptionD' => 'nullable|string',
            'CorrectOption' => 'required|in:A,B,C,D',
            'SubjectGradeId' => 'required|exists:subject_grades,Id',
        ]);

        $questionAnswer = QuestionAnswer::create([
            'Content' => $request->Content,
            'Difficulty' => $request->Difficulty,
            'OptionA' => $request->OptionA,
            'OptionB' => $request->OptionB,
            'OptionC' => $request->OptionC, // Can be null
            'OptionD' => $request->OptionD, // Can be null
            'CorrectOption' => $request->CorrectOption,
            'SubjectGradeId' => $request->SubjectGradeId,
        ]);

        return response()->json($questionAnswer, 201);
    }
}

