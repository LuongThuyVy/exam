<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SubjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\AuthController;


Route::post('/subjects', [SubjectController::class, 'store']);
Route::get('/subjects', [SubjectController::class, 'index']);

// Route::apiResource('/roles', RoleController::class);
Route::post('/roles', [RoleController::class, 'store']);
Route::get('/roles', [RoleController::class, 'index']);

Route::post('/grades', [GradeController::class, 'store']);
Route::get('/grades', [GradeController::class, 'index']);

Route::post('/register', [AuthController::class, 'register']);
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
