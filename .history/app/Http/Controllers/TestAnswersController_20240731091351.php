<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\testAnswer;
use App\Models\Test;

class TestAnswersController extends Controller
{
    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'time' => 'required|integer', // Validate the time as an integer
            'TestId' => 'required|exists:tests,id',
            'answers' => 'required|array',
            'answers.*.SelectedOption' => 'required|in:A,B,C,D',
            'answers.*.QuestionAnswerId' => 'required|exists:question_answers,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $testId = $request->input('TestId');
        $timeInSeconds = $request->input('time');
        $answers = $request->input('answers');

        // Retrieve the test instance
        $test = Test::findOrFail($testId);

        // Update the CompletionTime field by adding the duration to the current time
        // $completionTime = now()->addSeconds($timeInSeconds);
        // $test->CompletionTime = $completionTime;
        $test->save();

        $createdAnswers = [];

        foreach ($answers as $answer) {
            $testAnswer = new TestAnswer();
            $testAnswer->TestId = $testId;
            $testAnswer->SelectedOption = $answer['SelectedOption'];
            $testAnswer->QuestionAnswerId = $answer['QuestionAnswerId'];
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
