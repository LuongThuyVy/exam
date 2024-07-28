namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    // Lấy danh sách tất cả môn học
    public function index()
    {
        try {
            $subjects = Subject::all();
            return response()->json($subjects);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to fetch subjects.'], 500);
        }
    }

    // Lấy môn học theo ID
    public function show($id)
    {
        try {
            $subject = Subject::findOrFail($id);
            return response()->json($subject);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Subject not found.'], 404);
        }
    }

    // Thêm môn học mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $subject = Subject::create([
                'name' => $request->input('name'),
            ]);
            return response()->json($subject, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to create subject.'], 500);
        }
    }

    // Cập nhật môn học
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            $subject = Subject::findOrFail($id);
            $subject->name = $request->input('name');
            $subject->save();
            return response()->json($subject);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to update subject.'], 500);
        }
    }

    // Xóa môn học
    public function destroy($id)
    {
        try {
            $subject = Subject::findOrFail($id);
            $subject->delete();
            return response()->json(['message' => 'Subject deleted successfully.']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Unable to delete subject.'], 500);
        }
    }
}
