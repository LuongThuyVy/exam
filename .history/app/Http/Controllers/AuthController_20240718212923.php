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
            ''
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
            'LockEnable' => 1,
            'CreateDate' => now(),
            'RoleId' => $role->id,
        ]);
   
        // Tạo Examinee mới
        Examinee::create([
            'FullName' => $request->full_name,
            'birth' => $request->birth,
            'gender' => $request->gender,
            'AddressDetail' => $request->address_detail ?? '',
            'AccountId' => $account->id,
            'gradeid' => $request->grade_id ?? null,
        ]);
       
        return response()->json(['message' => 'Account created successfully'], 200);
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
        $account = Account::where('email', '=', $request->email)->first();

        if (!$account || !Hash::check($request->password, $account->password)) {
            return response()->json(['error' => 'Invalid email or password'], 401);
        }

        // Lấy thông tin role của account
        $role = $account->role->name;

        return response()->json([
            'message' => 'Login successful',
            'account' => [
                'id' => $account->id,
                'email' => $account->email,
                'phone' => $account->phone,
                'avatar' => $account->avatar,
                'createdate' => $account->create_date,
                'role' => $role,
            ],
        ], 200);
    }
}
