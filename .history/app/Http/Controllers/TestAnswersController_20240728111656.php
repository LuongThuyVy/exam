<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TestAnswersController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'TestId' => 'required|exists:tests,id',
            'answers' => 'required|array',
            'answers.*.SelectedOption' => 'required|in:A,B,C,D',
            'answers.*.QuestionAnsweredId' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $testId = $request->input('TestId');
        $answers = $request->input('answers');

        $createdAnswers = [];

        foreach ($answers as $answer) {
            $testAnswer = new TestAnswer();
            $testAnswer->TestId = $testId;
            $testAnswer->SelectedOption = $answer['SelectedOption'];
            $testAnswer->QuestionAnsweredId = $answer['QuestionAnsweredId'];
            $testAnswer->IsCorrect = $this->checkIfCorrect($answer['QuestionAnsweredId'], $answer['SelectedOption']);
            $testAnswer->save();

            $createdAnswers[] = $testAnswer;
        }

        return response()->json($createdAnswers, 201);
    }

    private function checkIfCorrect($questionId, $selectedOption)
    {
        $question = \DB::table('exam_answer')->find($questionId);
        return $question->CorrectOption === $selectedOption ? 1 : 0;
    }
}
