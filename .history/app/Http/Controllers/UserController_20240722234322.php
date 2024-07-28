<
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;

class UserController extends Controller
{
    // Lấy toàn bộ thông tin người dùng
    public function getAllUsers()
    {
        $accounts = Account::with('examinee')->get();
        return response()->json($accounts, 200);
    }

    // Lấy thông tin người dùng theo ID
    public function getUserById($id)
    {
        $account = Account::with('examinee')->find($id);

        if ($account) {
            return response()->json($account, 200);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
}
