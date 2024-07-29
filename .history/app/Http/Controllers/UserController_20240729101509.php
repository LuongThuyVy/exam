<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Account;
use Illuminate\Support\Facades\Log;
class UserController extends Controller
{
    // Lấy toàn bộ thông tin người dùng
//     public function getAllUsers()
// {
//     $accounts = Account::with('examinee')->get();
//     foreach ($accounts as $account) {
//         \Log::info($account);
//     }
//     return response()->json($accounts, 200);
// }
public function getAllUsers(Request $request)
{
    $perPage = $request->query('per_page', 10); // Default to 10 items per page
    $page = $request->query('page', 1); // Default to page 1

    $accounts = Account::with('examinee')
                        ->paginate($perPage, ['*'], 'page', $page);

    return response()->json($accounts, 200);
}


    public function getUserById($id)
    {
        $account = Account::with('examinee')->find($id);

        if ($account) {
            \Log::info($account);
            return response()->json($account, 200);
        } else {
            return response()->json(['message' => 'User not found'], 404);
        }
    }
   
    public function updateLockStatus($id, Request $request)
{
    $account = Account::where('Id', $id)->first();
    Log::info('Query result:', ['account' => $account]);
    if (!$account) {
        return response()->json(['message' => 'Account not found'], 404);
    }

    Log::info('Updating account with Id: ' . $id);
    Log::info('Request data:', $request->all());

    $newLockEnable = $request->has('LockEnable');
    $account->LockEnable = $newLockEnable;

    Log::info('Account before save:', $account->getDirty());

    DB::enableQueryLog();
    $saved = $account->save();
    Log::info('SQL Query:', DB::getQueryLog());

    $account->refresh();
    Log::info('Account after refresh:', $account->toArray());

    Log::info('Save result: ', ['saved' => $saved]);

    return response()->json([
        'message' => 'Account updated successfully',
        'lockEnable' => $account->LockEnable
    ], 200);
}
}
