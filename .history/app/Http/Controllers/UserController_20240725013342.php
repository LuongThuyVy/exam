<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;

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
    $account = Account::find($id);
    
    if (!$account) {
        return response()->json(['message' => 'Account not found'], 404);
    }

    $request->validate([
        'LockEnable' => 'required|boolean'
    ]);

    $account->LockEnable = $request->input('LockEnable');
    $account->save();

    return response()->json(['message' => 'Account updated successfully'], 200);
}



}
