
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;

class SubjectController extends Controller
{
    // Lấy danh sách môn học
    public function index()
    {
        $subjects = Subject::all();
        return response()->json($subjects, 200);
    }

    // Thêm môn học mới
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);

        $subject = Subject::create([
            'name' => $request->name,
        ]);

        return response()->json($subject, 201);
    }

    // Sửa môn học
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:50',
        ]);

        $subject = Subject::findOrFail($id);
        $subject->update([
            'name' => $request->name,
        ]);

        return response()->json($subject, 200);
    }

    // Xóa môn học
    public function destroy($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return response()->json(null, 204);
    }
}
