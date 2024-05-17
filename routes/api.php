<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InstituteController;
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\DistrictController;
use App\Http\Controllers\Api\DivisionController;
use App\Http\Controllers\Api\UpazillaController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\PiEvalutionController;
use App\Http\Controllers\Api\BiEvalutionController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::get('/institute', [InstituteController::class, 'index']);
// Route::post('/institute', [InstituteController::class, 'store']);

// Route::get('/teacher', [TeacherController::class, 'index']);
// Route::post('/teacher', [TeacherController::class, 'store']);

// Route::get('/student', [StudentController::class, 'index']);
// Route::post('/student', [StudentController::class, 'store']);

Route::group(['middleware' => ['json.response', 'api.share.sso']], function () {
    Route::post('/head-teacher', [InstituteController::class, 'storeInstituteHeadMaster']);
    Route::get('/teacher-dashboard', [DashboardController::class, 'teacherDashboard']);
    Route::get('/own-subjects', [TeacherController::class, 'OwnSubject']);

    Route::get('/division', [DivisionController::class, 'index']);
    Route::post('/division', [DivisionController::class, 'store']);
    Route::put('/division/{id}', [DivisionController::class, 'update']);

    Route::get('/district', [DistrictController::class, 'index']);
    Route::post('/district', [DistrictController::class, 'store']);
    Route::put('/district/{id}', [DistrictController::class, 'update']);

    Route::get('/upazilla', [UpazillaController::class, 'index']);
    Route::post('/upazilla', [UpazillaController::class, 'store']);
    Route::put('/upazilla/{id}', [UpazillaController::class, 'update']);

    Route::post('/pi-evaluation', [PiEvalutionController::class, 'store']);
    Route::post('/bi-evaluation', [BiEvalutionController::class, 'store']);
    
    Route::get('/get-pi-evaluation-by-pi', [PiEvalutionController::class, 'getPiEvaluationByPi']);
    Route::get('/get-bi-evaluation-by-bi', [BiEvalutionController::class, 'getBiEvaluationByBi']);

    Route::get('/upazila-institute-headmaster/{uzid}', [InstituteController::class, 'upazilaInstituteWithHeadMaster']);
    Route::get('/institute-teacher', [InstituteController::class, 'upazilaTeachers']);
    Route::post('/institute-headmaster', [InstituteController::class, 'updateInstituteHeadMaster']);

    Route::get('/institute', [InstituteController::class, 'index']);
    Route::post('/institute', [InstituteController::class, 'store']);

    Route::get('/teacher', [TeacherController::class, 'index']);
    Route::post('/teacher', [TeacherController::class, 'store']);
    Route::put('/teachers/{id}', [TeacherController::class, 'update']);

    Route::get('/student', [StudentController::class, 'index']);
    Route::post('/student', [StudentController::class, 'store']);
});
