<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AssignController;
use App\Http\Controllers\Admin\ScheduleController;
use App\Http\Controllers\Admin\HomeController as HomeAdmin;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\HomeController as Home;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\Teacher\AttendanceController;
use App\Http\Controllers\Teacher\HomeController as HomeTeacher;
use App\Http\Controllers\YearSchoolController;
use App\Models\Assign;
use App\Models\Attendance;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// chi danh cho user(admin,teacher)
Route::middleware(['auth:admin,teacher', 'isActive'])->group(function() {
    // logout
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    //profile
   Route::name('profile.')->group(function() {
        // show profile
        Route::get('/profile', [ProfileController::class, 'show'])
            ->name('show');

        // update profile
        Route::put('/profile', [ProfileController::class, 'update'])
            ->name('update');
   });

   // change password
   Route::put('/password', [ChangePasswordController::class, 'changePassword'])
        ->name('password');
});

// chi danh cho admin
Route::middleware(['auth:admin', 'isActive'])->group(function() {
    Route::prefix('admin')->name('admin.')->group(function() {
        // dashboard
        Route::get('', [HomeAdmin::class, 'index'])
            ->name('dashboard');

        Route::resource('yearschool', YearSchoolController::class);
        Route::resource('grade', GradeController::class);
        Route::resource('subject', SubjectController::class);
        Route::resource('classroom', ClassroomController::class);

        // manager teacher
        Route::resource('teacher-manager', TeacherController::class);

        // manager admin
        Route::resource('admin-manager', AdminController::class)
              ->middleware('isSuper');

        Route::resource('lesson', LessonController::class);

        Route::resource('student-manager', StudentController::class);

        // assign
        Route::resource('assign', AssignController::class);

        // schedule
        Route::resource('schedule', ScheduleController::class);
        Route::get('scheduleIndexAll', [ScheduleController::class, 'indexAll'])->name('schedule.indexAll');
        Route::get('scheduleIndexTeacher', [ScheduleController::class, 'indexTeacher'])->name('schedule.indexTeacher');
        Route::get('scheduleIndexClass', [ScheduleController::class, 'indexClass'])->name('schedule.indexClass');
        Route::POST('schedule.ajax', [ScheduleController::class, 'requestAjax'])->name('schedule.requestAjax');
        Route::POST('schedule.update.ajax', [ScheduleController::class, 'updateMultiSchedule'])->name('schedule.updateMultiSchedule');
    });
});

// chi danh cho teacher
Route::middleware(['auth:teacher', 'isActive'])->group(function() {
    Route::prefix('teacher')->name('teacher.')->group(function() {
        Route::get('', [HomeTeacher::class, 'index'])
            ->name('dashboard');
        // attendance
        Route::get('attendance/history', [
            AttendanceController::class, 'history'
        ])->name('attendance.history');

        Route::post('attendance/history', [
            AttendanceController::class, 'updatehistory'
        ])->name('attendance.update_history');
        
        Route::resource('attendance', AttendanceController::class);
    });
});


// route dang nhap
Route::prefix('login')->name('login.')->group(function() {
    Route::get('admin', [LoginController::class, 'showAdminLoginForm'])
    ->name('admin_form');

    Route::get('teacher', [LoginController::class, 'showTeacherLoginForm'])
    ->name('teacher_form');

    Route::post('admin', [LoginController::class, 'adminLogin'])
    ->name('admin');

    Route::post('teacher', [LoginController::class, 'teacherLogin'])
    ->name('teacher');
});

// home page (auth, guest)
Route::get('/', [Home::class, 'index'])->name('home');

// error
Route::prefix('error')->name('error.')->group(function() {
    Route::view('401', 'errors.401')->name('401');
    Route::view('403', 'errors.403')->name('403');
    Route::view('404', 'errors.404')->name('404');
    Route::view('419', 'errors.419')->name('419');
    Route::view('429', 'errors.429')->name('429');
    Route::view('500', 'errors.500')->name('500');
    Route::view('503', 'errors.503')->name('503');
    Route::view('', 'errors.custom')->name('custom');
});

// test
Route::get('/test', function() {
  // $students = Grade::find(1)->students;
  // $data = [];
  // // dd($students);
  // $assign = Assign::find(8);
  // foreach ($students as $key => $student) {
  //     $students[$key]->fetchInfoAttendance($assign);
  //     $data[] = (object) [
  //       "id" => $students[$key]->id,
  //       "code" => $students[$key]->code,
  //       "name" => $students[$key]->name,
  //       "infoAttendance" => $students[$key]->infoAttendance
  //     ];
  // }
  $attendance = Attendance::find(30);
  $attendanceDetails = $attendance->attendanceDetails;
  dd($attendanceDetails->map->only('status')->toArray());

});


