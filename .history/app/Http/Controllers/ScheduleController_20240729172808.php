<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index($accountId)
    {
        // Fetch all exam shifts related to the given account ID
        $examShifts = Test::where('ExamineeId', $accountId)
            ->with('examShift') // Assuming you have a relationship named examShift
            ->get()
            ->pluck('examShift');

        // Return the exam shifts as JSON response
        return response()->json($examShifts);
    }
}
