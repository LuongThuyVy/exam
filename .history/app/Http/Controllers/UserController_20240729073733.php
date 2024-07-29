<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;

[2024-07-29 00:36:45] local.ERROR: Class 'App\Http\Controllers\Log' not found {"exception":"[object] (Error(code: 0): Class 'App\\Http\\Controllers\\Log' not found at C:\\Users\\DELL\\example\\exam\\app\\Http\\Controllers\\UserController.php:55)
    [stacktrace]
    #0 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Controller.php(54): App\\Http\\Controllers\\UserController->updateLockStatus('1', Object(Illuminate\\Http\\Request))
    #1 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\ControllerDispatcher.php(45): Illuminate\\Routing\\Controller->callAction('updateLockStatu...', Array)
    #2 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(262): Illuminate\\Routing\\ControllerDispatcher->dispatch(Object(Illuminate\\Routing\\Route), Object(App\\Http\\Controllers\\UserController), 'updateLockStatu...')
    #3 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Route.php(205): Illuminate\\Routing\\Route->runController()
    #4 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(721): Illuminate\\Routing\\Route->run()
    #5 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Routing\\Router->Illuminate\\Routing\\{closure}(Object(Illuminate\\Http\\Request))
    #6 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\SubstituteBindings.php(50): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))
    #7 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(167): Illuminate\\Routing\\Middleware\\SubstituteBindings->handle(Object(Illuminate\\Http\\Request), Object(Closure))
    #8 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(127): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))
    #9 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(103): Illuminate\\Routing\\Middleware\\ThrottleRequests->handleRequest(Object(Illuminate\\Http\\Request), Object(Closure), Array)
    #10 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Middleware\\ThrottleRequests.php(55): Illuminate\\Routing\\Middleware\\ThrottleRequests->handleRequestUsingNamedLimiter(Object(Illuminate\\Http\\Request), Object(Closure), 'api', Object(Closure))
    #11 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(167): Illuminate\\Routing\\Middleware\\ThrottleRequests->handle(Object(Illuminate\\Http\\Request), Object(Closure), 'api')
    #12 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))
    #13 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(723): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
    #14 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(698): Illuminate\\Routing\\Router->runRouteWithinStack(Object(Illuminate\\Routing\\Route), Object(Illuminate\\Http\\Request))
    #15 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(662): Illuminate\\Routing\\Router->runRoute(Object(Illuminate\\Http\\Request), Object(Illuminate\\Routing\\Route))
    #16 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Routing\\Router.php(651): Illuminate\\Routing\\Router->dispatchToRoute(Object(Illuminate\\Http\\Request))
    #17 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(167): Illuminate\\Routing\\Router->dispatch(Object(Illuminate\\Http\\Request))
    #18 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(128): Illuminate\\Foundation\\Http\\Kernel->Illuminate\\Foundation\\Http\\{closure}(Object(Illuminate\\Http\\Request))
    #19 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))
    #20 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull.php(31): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))
    #21 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(167): Illuminate\\Foundation\\Http\\Middleware\\ConvertEmptyStringsToNull->handle(Object(Illuminate\\Http\\Request), Object(Closure))
    #22 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest.php(21): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))
    #23 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\TrimStrings.php(40): Illuminate\\Foundation\\Http\\Middleware\\TransformsRequest->handle(Object(Illuminate\\Http\\Request), Object(Closure))
    #24 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(167): Illuminate\\Foundation\\Http\\Middleware\\TrimStrings->handle(Object(Illuminate\\Http\\Request), Object(Closure))
    #25 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize.php(27): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))
    #26 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(167): Illuminate\\Foundation\\Http\\Middleware\\ValidatePostSize->handle(Object(Illuminate\\Http\\Request), Object(Closure))
    #27 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance.php(86): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))
    #28 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(167): Illuminate\\Foundation\\Http\\Middleware\\PreventRequestsDuringMaintenance->handle(Object(Illuminate\\Http\\Request), Object(Closure))
    #29 C:\\Users\\DELL\\example\\exam\\vendor\\fruitcake\\laravel-cors\\src\\HandleCors.php(52): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))
    #30 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(167): Fruitcake\\Cors\\HandleCors->handle(Object(Illuminate\\Http\\Request), Object(Closure))
    #31 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Http\\Middleware\\TrustProxies.php(39): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))
    #32 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(167): Illuminate\\Http\\Middleware\\TrustProxies->handle(Object(Illuminate\\Http\\Request), Object(Closure))
    #33 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Pipeline\\Pipeline.php(103): Illuminate\\Pipeline\\Pipeline->Illuminate\\Pipeline\\{closure}(Object(Illuminate\\Http\\Request))
    #34 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(142): Illuminate\\Pipeline\\Pipeline->then(Object(Closure))
    #35 C:\\Users\\DELL\\example\\exam\\vendor\\laravel\\framework\\src\\Illuminate\\Foundation\\Http\\Kernel.php(111): Illuminate\\Foundation\\Http\\Kernel->sendRequestThroughRouter(Object(Illuminate\\Http\\Request))
    #36 C:\\Users\\DELL\\example\\exam\\public\\index.php(52): Illuminate\\Foundation\\Http\\Kernel->handle(Object(Illuminate\\Http\\Request))
    #37 C:\\Users\\DELL\\example\\exam\\server.php(21): require_once('C:\\\\Users\\\\DELL\\\\e...')
    #38 {main}
    "} 
    
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

    Log::info('Updating account with ID: ' . $id, $request->all());

    $account->LockEnable = $request->input('LockEnable') ? 1 : 0; // Đảm bảo dữ liệu được lưu đúng kiểu
    $saved = $account->save();

    Log::info('Updated account: ', $account->toArray());
    Log::info('Save result: ', ['saved' => $saved]);

    return response()->json(['message' => 'Account updated successfully'], 200);
}





}
