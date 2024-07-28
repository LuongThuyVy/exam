<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\testAnswer;

class TestAnswersController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'TestId' => 'required|exists:tests,id',
            'answers' => 'required|array',
            'answers.*.SelectedOption' => 'required|in:A,B,C,D',
            'answers.*.QuestionAnswerId' => 'requireduse App\Models\SubjectGrade;
',
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
            $testAnswer->QuestionAnsweredId = $answer['QuestionAnswerId'];
            $testAnswer->IsCorrect = $this->checkIfCorrect($answer['QuestionAnswerId'], $answer['SelectedOption']);
            $testAnswer->save();

            $createdAnswers[] = $testAnswer;
        }

        return response()->json($createdAnswers, 201);
    }

    private function checkIfCorrect($questionId, $selectedOption)
    {
        $question = \DB::table('question_answers')->find($questionId);
        return $question->CorrectOption === $selectedOption ? 1 : 0;
    }
}
