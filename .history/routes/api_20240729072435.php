<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\SubjectController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\QuestionAnswerController;
use App\Http\Controllers\SubjectGradeController;
use App\Http\Controllers\ExamController;
use App\Http\Controllers\ExamQuestionController;
use App\Http\Controllers\ExamShiftController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\TestAnswersController;


Route::post('/tests/submit', [TestAnswersController::class, 'store']);

Route::post('/tests', [TestController::class, 'store']);

Route::get('/exam-shifts', [ExamShiftController::class, 'index']);
Route::get('/exam-shifts/{id}', [ExamShiftController::class, 'show']);
Route::post('/exam-shifts', [ExamShiftController::class, 'store']);
Route::put('/exam-shifts/{id}', [ExamShiftController::class, 'update']);
Route::delete('/exam-shifts/{id}', [ExamShiftController::class, 'destroy']);


Route::get('exam-questions/{examId}', [ExamQuestionController::class, 'index']);
Route::post('exam-questions', [ExamQuestionController::class, 'store']);
Route::put('exam-questions/{id}', [ExamQuestionController::class, 'update']);
Route::delete('exam-questions/{id}', [ExamQuestionController::class, 'destroy']);

Route::get('/exams', [ExamController::class, 'index']);
Route::get('/exams/{id}', [ExamController::class, 'show']);
Route::post('/exams', [ExamController::class, 'store']);
Route::put('/exams/{id}', [ExamController::class, 'update']);
Route::delete('/exams/{id}', [ExamController::class, 'destroy']);

Route::get('/subject-grades', [SubjectGradeController::class, 'index']);
Route::post('/subject-grades', [SubjectGradeController::class, 'store']);
Route::get('/subject-grades/{id}', [SubjectGradeController::class, 'show']);
Route::put('/subject-grades/{id}', [SubjectGradeController::class, 'update']);
Route::delete('/subject-grades/{id}', [SubjectGradeController::class, 'destroy']);

Route::post('/questions', [QuestionAnswerController::class, 'store']);
Route::put('/users/{id}', [UserController::class, 'updateLockStatus']);


Route::put('/users/lock/{id}', [UserController::class, 'updateLockStatus']);
Route::get('/users', [UserController::class, 'getAllUsers']);
Route::get('/user/{id}', [UserController::class, 'getUserById']);

Route::patch('/accounts/{id}', [UserController::class, 'updateLockStatus']);

Route::get('subjects', [SubjectController::class, 'index']);
Route::get('subjects/{id}', [SubjectController::class, 'show']);
Route::post('subjects', [SubjectController::class, 'store']);
Route::put('subjects/{id}', [SubjectController::class, 'update']);
Route::delete('subjects/{id}', [SubjectController::class, 'destroy']);


Route::post('/roles', [RoleController::class, 'store']);
Route::get('/roles', [RoleController::class, 'index']);

Route::post('/grades', [GradeController::class, 'store']);
Route::get('/grades', [GradeController::class, 'index']);

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
