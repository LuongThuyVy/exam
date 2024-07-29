<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ExamShift; // Import model ExamShift if needed
use App\Models\Test; // Import model Test if needed

class ExamShiftByUserController extends Controller
{
    public function index($accountId)
    {
        // Fetch all exam shifts for the given account ID
        $examShifts = Test::where('ExamineeId', $accountId)
            ->with('examShift') // Assuming you have a relationship named examShift
            ->get()
            ->pluck('examShift'); // Retrieve only the examShift details
        
        // If you want to include specific attributes of examShift, you can do:
        // $examShifts = Test::where('ExamineeId', $accountId)
        //     ->with('examShift:id,name,startTime,endTime,Description,Duration,TotalQuestions') 
        //     ->get()
        //     ->pluck('examShift');

        // Return the exam shifts as JSON response
        return response()->json($examShifts);
    }
}
