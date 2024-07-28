<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;
use App\Models\Account;
use App\Models\Examinee;

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
            'grade_id' => 'required|int',
            'address_detail' => 'required|string|max:100'
        ]);
    
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
    
        // Tìm role mặc định là user
        $role = Role::where('Name', 'user')->first();
    
        if (!$role) {
            return response()->json(['error' => 'Role not found'], 404);
        }
    
        // Tạo Account mới
        $hashedPassword = Hash::make($request->password);
        \Log::info('Hashed Password: ' . $hashedPassword);
    
        $account = Account::create([
            'Email' => $request->email,
            'phone' => $request->phone,
            'password' => $hashedPassword,
            'LockEnable' => 1,
            'CreateDate' => now(),
            'RoleId' => $role->Id,
        ]);
    
        // Đảm bảo $account đã được tạo và có ID
        if ($account) {
            // Tạo Examinee mới
            Examinee::create([
                'FullName' => $request->full_name,
                'birth' => $request->birth,
                'gender' => $request->gender,
                'AddressDetail' => $request->address_detail,
                'AccountId' => $account->id,
                'gradeid' => $request->grade_id,
            ]);
        } else {
            return response()->json(['error' => 'Account creation failed'], 500);
        }
    
        return response()->json(['success' => 'Registration successful'], 201);
    }
    

public function login(Request $request)
{
    // Validate dữ liệu đầu vào
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    // Tìm account theo email
    $account = Account::where('email', $request->email)->first();

    if (!$account) {
        return response()->json(['error' => 'Account not found'], 404);
    }

    \Log::info('Input Password: ' . $request->password);
    \Log::info('Stored Hashed Password: ' . $account->password);
    \Log::info('Stored Hashed Password: ' . $account);


    if (!Hash::check($request->password, $account->Password)) {
        return response()->json(['error' => 'Invalid email or password'], 401);
    }

    // Lấy thông tin role của account
    $role = Role::where('Id',$account->RoleId)->first();

    return response()->json([
        'message' => 'Login successful',
        'account' => [
            'id' => $account->Id,
            'email' => $account->Email,
            'phone' => $account->Phone,
            'createdate' => $account->CreateDate,
            'role' => $role->Name,
        ],
    ], 200);
}

}
