namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Test;
use App\Models\Examinee;
use App\Models\ExamShift;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    public function getPendingTests(Request $request, $accountId)
    {
        // Get current time
        $currentTime = Carbon::now();

        // Fetch the Examinee based on AccountId
        $examinee = Examinee::where('AccountId', $accountId)->first();

        if (!$examinee) {
            return response()->json(['message' => 'Examinee not found.'], 404);
        }

        // Fetch all tests for the examinee where completion time is null
        // and the related exam shift's end time is greater than or equal to the current time
        $pendingTests = Test::where('ExamineeId', $examinee->Id)
            ->whereNull('CompletionTime')
            ->whereHas('examShift', function ($query) use ($currentTime) {
                $query->where('EndTime', '>=', $currentTime);
            })
            ->with(['examShift' => function ($query) {
                $query->with(['exam.subjectGrade.subject', 'exam.subjectGrade.grade']);
            }])
            ->get();

        // Format the pending tests
        $formattedPendingTests = $pendingTests->map(function ($test) {
            $examShift = $test->examShift;
            $exam = $examShift->exam;

            return [
                'testId' => $test->Id,
                'examineeId' => $test->ExamineeId,
                'examShift' => [
                    'id' => $examShift->Id,
                    'name' => $examShift->Name,
                    'startTime' => $examShift->StartTime,
                    'endTime' => $examShift->EndTime,
                    'subjectgrade' => $exam ? [
                        'Id' => $exam->Id,
                        'Name' => $exam->Name,
                        'Description' => $exam->Description,
                        'Duration' => $exam->Duration,
                        'TotalQuestions' => $exam->TotalQuestions,
                        'SubjectGradeId' => $exam->subjectGrade->Id ?? null,
                        'subject_grade' => $exam->subjectGrade ? [
                            'Id' => $exam->subjectGrade->Id,
                            'SubjectId' => $exam->subjectGrade->SubjectId,
                            'GradeId' => $exam->subjectGrade->GradeId,
                            'subject' => $exam->subjectGrade->subject ? [
                                'Id' => $exam->subjectGrade->subject->Id,
                                'Name' => $exam->subjectGrade->subject->Name,
                            ] : null,
                            'grade' => $exam->subjectGrade->grade ? [
                                'Id' => $exam->subjectGrade->grade->Id,
                                'Name' => $exam->subjectGrade->grade->Name,
                            ] : null,
                        ] : null,
                    ] : null,
                ]
            ];
        });

        return response()->json($formattedPendingTests);
    }
}
