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
use App\Http\Controllers\ScheduleController;    
use App\Http\Controllers\WaitingRoomController;

Route::get('/waiting-room/{accountId}', [WaitingRoomController::class, 'getCurrentExamShifts']);

Route::get('/schedule/{accountId}', [ScheduleController::class, 'getPendingTests']);

Route::post('/tests/submit', [TestAnswersController::class, 'store']);
Route::put('/tests/{id}', [TestController::class, 'update']);
Route::delete('/tests/{id}', [TestController::class, 'destroy']);
Route::post('/tests', [TestController::class, 'store']);
Route::get('/tests/{id}', [TestController::class, 'show']);
Route::get('/tests', [TestController::class, 'getAll']);
Route::get('/tests/history/{accountId}', [TestController::class, 'History']);

Route::get('/exam-shifts', [ExamShiftController::class, 'index']);
Route::get('/exam-shifts/{id}', [ExamShiftController::class, 'show']);
Route::post('/exam-shifts', [ExamShiftController::class, 'store']);
Route::put('/exam-shifts/{id}', [ExamShiftController::class, 'update']);
Route::delete('/exam-shifts/{id}', [ExamShiftController::class, 'destroy']);
Route::get('/exam-shifts/user/{id}', [ExamShiftController::class, 'getAvailableExamShifts']);

Route::get('exam-questions/{id}', [ExamQuestionController::class, 'index']); //examshiftid
Route::get('exam-detail/{id}', [ExamQuestionController::class, 'ExamDetail']); //examid
Route::post('exam-questions', [ExamQuestionController::class, 'store']);
Route::put('exam-questions/{id}', [ExamQuestionController::class, 'update']);
Route::delete('exam-questions/{id}', [ExamQuestionController::class, 'destroy']);

Route::post('exam-questions/add', [ExamQuestionController::class, 'addQuestions']);

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

Route::get('/questions', [QuestionAnswerController::class, 'getAllQuestions']);
Route::get('/questions/condition/{id}', [QuestionAnswerController::class, 'getQuestionsWithCondition']); //examid laâấ
Route::post('/questions', [QuestionAnswerController::class, 'store']);
Route::put('/questions/{id}', [QuestionAnswerController::class, 'update']);
Route::delete('/questions/{id}', [QuestionAnswerController::class, 'destroy']);

Route::put('/users/lock/{id}', [UserController::class, 'updateLockStatus']);
Route::get('/users', [UserController::class, 'getAllUsers']);
Route::get('/user/{id}', [UserController::class, 'getUserById']);
Route::put('/users/{id}', [UserController::class, 'updateUserInfo']);

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
