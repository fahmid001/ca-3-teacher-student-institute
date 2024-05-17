<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AjaxController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AutoSeedInstituteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });
// Route::get('seed-ins', [AutoSeedInstituteController::class, 'autoSend'])->name('seed-ins');
Route::get('login', [LoginController::class, 'login'])->name('login');
Route::get('login/callback', [LoginController::class, 'handleCallback'])->name('login.callback');

Route::group(['middleware' => ['auth', 'share.sso']], function () {
    Route::get('logout', [LoginController::class, 'logout'])->name('logout');
    // Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    // Route::get('/', [App\Http\Controllers\HomeController::class, 'login'])->name('login');
    Route::post('/register', [App\Http\Controllers\HomeController::class, 'register'])->name('register');
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'dashboard'])->name('dashboard');
    Route::get('/', [App\Http\Controllers\HomeController::class, 'noipunnoDashboard'])->name('home');
   // Route::get('/', [App\Http\Controllers\HomeController::class, 'noipunnoDashboard2'])->name('home');
    Route::get('/noipunno-dashboard-style-components', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardComponents'])->name('noipunno.dashboard.components');
    Route::get('/noipunno-dashboard/upazilla', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardUpazilla'])->name('noipunno.dashboard.upazilla');
    Route::get('/noipunno-dashboard/school-details', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardSchoolDetails'])->name('noipunno.dashboard.schoolDetails');
    Route::get('/noipunno-dashboard/school-focal', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardSchoolFocal'])->name('noipunno.dashboard.SchoolFocal');
    // Route::get('/noipunno-dashboard/student-add', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardStudentAdd'])->name('noipunno.dashboard.student.add');
// Route::get('/noipunno-dashboard/student-edit', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardStudentEdit'])->name('noipunno.dashboard.student.edit');

    // Route::get('/noipunno-dashboard/teacher-add', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardTeacherAdd'])->name('noipunno.dashboard.teacher.add');
// Route::get('/noipunno-dashboard/teacher-edit', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardTeacherEdit'])->name('noipunno.dashboard.teacher.edit');
    Route::get('/branch_wise_version', [App\Http\Controllers\HomeController::class, 'branchWiseVersion'])->name('branch_wise_version');
    Route::get('/class_wise_subject', [App\Http\Controllers\HomeController::class, 'classWiseSubject'])->name('class_wise_subject');
    Route::get('/class_wise_section', [App\Http\Controllers\HomeController::class, 'classWiseSection'])->name('class_wise_section');
    Route::get('/section_wise_year', [App\Http\Controllers\HomeController::class, 'sectionWiseYear'])->name('section_wise_year');

    Route::get('/noipunno-dashboard/classroom-add', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardClassRoomAdd'])->name('noipunno.dashboard.classroom.add');
    Route::post('/noipunno-dashboard/classroom-store', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardClassRoomStore'])->name('noipunno.dashboard.classroom.store');
    Route::get('/noipunno-dashboard/classroom-edit/{id}', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardClassRoomEdit'])->name('noipunno.dashboard.classroom.edit');
    Route::post('/noipunno-dashboard/classroom-update/{id}', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardClassRoomUpdate'])->name('noipunno.dashboard.classroom.update');
    Route::post('/noipunno-dashboard/classroom-delete', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardClassRoomDelete'])->name('noipunno.dashboard.classroom.delete');

    Route::get('/noipunno-dashboard/branch-add', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardBranchAdd'])->name('noipunno.dashboard.branch.add');
    Route::post('/noipunno-dashboard/branch-store', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardBranchStore'])->name('noipunno.dashboard.branch.store');
    Route::get('/noipunno-dashboard/branch-edit/{id?}', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardBranchEdit'])->name('noipunno.dashboard.branch.edit');
    Route::put('/noipunno-dashboard/branch-update/{id}', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardBranchUpdate'])->name('noipunno.dashboard.branch.update');
    Route::post('/noipunno-dashboard/branch-delete', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardBranchDelete'])->name('noipunno.dashboard.branch.delete');

    Route::get('/noipunno-dashboard/version-add', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardVersionAdd'])->name('noipunno.dashboard.version.add');
    Route::post('/noipunno-dashboard/version-store', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardVersionStore'])->name('noipunno.dashboard.version.store');
    Route::get('/noipunno-dashboard/version-edit/{id?}', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardVersionEdit'])->name('noipunno.dashboard.version.edit');
    Route::put('/noipunno-dashboard/version-update/{id}', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardVersionUpdate'])->name('noipunno.dashboard.version.update');

    Route::get('/noipunno-dashboard/shift-add', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardShiftAdd'])->name('noipunno.dashboard.shift.add');
    Route::post('/noipunno-dashboard/shift-add', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardShiftStore'])->name('noipunno.dashboard.shift.store');
    Route::get('/noipunno-dashboard/shift-edit/{id?}', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardShiftEdit'])->name('noipunno.dashboard.shift.edit');
    Route::put('/noipunno-dashboard/shift-edit/{id}', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardShiftUpdate'])->name('noipunno.dashboard.shift.update');

    Route::get('/noipunno-dashboard/section-add', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardSectionAdd'])->name('noipunno.dashboard.section.add');
    Route::post('/noipunno-dashboard/section-add', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardSectionStore'])->name('noipunno.dashboard.section.store');
    Route::get('/noipunno-dashboard/section-edit', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardSectionEdit'])->name('noipunno.dashboard.section.edit');
    Route::put('/noipunno-dashboard/section-edit', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardSectionUpdate'])->name('noipunno.dashboard.section.update');

    Route::get('/noipunno-dashboard/session-add', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardSessionAdd'])->name('noipunno.dashboard.session.add');
    Route::get('/noipunno-dashboard/session-edit', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardSessionEdit'])->name('noipunno.dashboard.session.edit');

    Route::get('/teachers', [App\Http\Controllers\Admin\TeacherController::class, 'index'])->name('teacher.index');
    Route::post('/teachers', [App\Http\Controllers\Admin\TeacherController::class, 'store'])->name('teacher.store');
    Route::get('/teachers/{id?}/edit', [App\Http\Controllers\Admin\TeacherController::class, 'edit'])->name('teacher.edit');
    Route::get('/teachers/{id?}/emis', [App\Http\Controllers\Admin\TeacherController::class, 'fromEmis'])->name('teacher.fromEmis');
    Route::get('/teachers/{id?}/banbies', [App\Http\Controllers\Admin\TeacherController::class, 'fromBanbies'])->name('teacher.fromBanbies');
    Route::put('/teachers/{id}', [App\Http\Controllers\Admin\TeacherController::class, 'update'])->name('teacher.update');
    Route::get('/teachers/get-teachers', [App\Http\Controllers\Admin\TeacherController::class, 'getAllTeachersByPdsID'])->name('teacher.getAllTeachersByPdsID');
    Route::post('/teachers/delete', [App\Http\Controllers\Admin\TeacherController::class, 'delete'])->name('teacher.delete');

    Route::get('/institutes', [App\Http\Controllers\Admin\InstituteController::class, 'index']);
    Route::post('/institutes', [App\Http\Controllers\Admin\InstituteController::class, 'store']);

    Route::get('/students', [App\Http\Controllers\Admin\StudentController::class, 'index'])->name('student.index');
    Route::post('/students', [App\Http\Controllers\Admin\StudentController::class, 'store'])->name('student.store');
    Route::get('/students/{id}/edit', [App\Http\Controllers\Admin\StudentController::class, 'edit'])->name('student.edit');
    Route::put('/students/{id}', [App\Http\Controllers\Admin\StudentController::class, 'update'])->name('student.update');
    Route::get('/students/download', [App\Http\Controllers\Admin\StudentController::class, 'download'])->name('student.download');
    Route::post('/students-import', [App\Http\Controllers\Admin\StudentController::class, 'import'])->name('student.import');
    Route::get('/student/get-branch-info', [App\Http\Controllers\Admin\StudentController::class, 'getAllRequiredDropdownForStudents'])->name('student.getBranchData');
    Route::get('/student/get-section-info', [App\Http\Controllers\Admin\StudentController::class, 'getSectionDropdownForStudents'])->name('student.getSectionData');
    Route::post('/students/delete', [App\Http\Controllers\Admin\StudentController::class, 'delete'])->name('student.delete');

    Route::get('/students/report', [App\Http\Controllers\HomeController::class, 'noipunnoDashboardStudentsReport'])->name('students.report');
});

Route::get('logs/{folder}/{filename}', function ($folder, $filename)
{
    $path = storage_path('logs/' . $folder .'/'. $filename);
    if (!File::exists($path)) {
        abort(404);
    }
    $file = File::get($path);
    $type = File::mimeType($path);
    $response = Response::make($file, 200);
    $response->header("Content-Type", $type);
    return $response;
});
