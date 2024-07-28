<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // Validate dữ liệu đầu vào
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|unique:accounts,email',
            'password' => 'required|min:6',
            'full_name' => 'required|string|max:100',
            'birth' => 'required|date',
            'gender' => 'required|in:Nam,Nữ,Khác',
            'phone' => 'required|string|max:20',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Tìm role mặc định là user
        $role = Role::where('name', 'user')->first();

        if (!$role) {
            return response()->json(['error' => 'Role not found'], 404);
        }

        // Tạo Account mới
        $account = Account::create([
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'lock_enable' => false,
            'create_date' => now(),
            'role_id' => $role->id,
        ]);

        // Tạo Examinee mới
        Examinee::create([
            'full_name' => $request->full_name,
            'birth' => $request->birth,
            'gender' => $request->gender,
            'address_detail' => $request->address_detail ?? '',
            'account_id' => $account->id,
            'grade_id' => $request->grade_id ?? null,
        ]);

        return response()->json(['message' => 'Account created successfully'], 200);
    }
    
}
