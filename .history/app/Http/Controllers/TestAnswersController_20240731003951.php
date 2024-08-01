namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TestAnswer;

class TestAnswersController extends Controller
{
    public function submit(Request $request)
    {
        $data = $request->validate([
            'TestId' => 'required|integer',
            'answers' => 'required|array',
            'CompletionTime' => 'required|integer',
        ]);

        foreach ($data['answers'] as $answer) {
            TestAnswer::create([
                'TestId' => $data['TestId'],
                'QuestionAnswerId' => $answer['QuestionAnswerId'],
                'SelectedOption' => $answer['SelectedOption'],
            ]);
        }

        // You can store or process the CompletionTime as needed
        $completionTime = $data['CompletionTime'];

        return response()->json([
            'message' => 'Test answers submitted successfully',
            'completionTime' => $completionTime,
        ]);
    }
}
