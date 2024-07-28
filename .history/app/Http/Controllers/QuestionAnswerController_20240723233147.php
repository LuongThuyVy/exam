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
            'OptionC' => 'string',
            'OptionD' => 'required|string',
            'CorrectOption' => 'required|in:A,B,C,D',
            'SubjectGradeId' => 'required|integer|exists:subject_grades,Id',
        ]);

        $question = QuestionAnswer::create([
            'Content' => $request->Content,
            'Difficulty' => $request->Difficulty,
            'OptionA' => $request->OptionA,
            'OptionB' => $request->OptionB,
            'OptionC' => $request->OptionC,
            'OptionD' => $request->OptionD,
            'CorrectOption' => $request->CorrectOption,
            'SubjectGradeId' => $request->SubjectGradeId,
        ]);

        return response()->json($question, 201);
    }
}
