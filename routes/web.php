<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\HomeController as HomeAdmin;
use App\Http\Controllers\Admin\TeacherController;
use App\Http\Controllers\Auth\ChangePasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\ClassroomController;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\HomeController as Home;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\Teacher\HomeController as HomeTeacher;
use App\Http\Controllers\YearSchoolController;
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
Route::middleware(['auth:admin,teacher'])->group(function() {
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

Route::get('/', function () {
    return view('admins.dashboard');
})->name('home');

// chi danh cho admin
Route::middleware(['auth:admin'])->group(function() {
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
        Route::resource('admin-manager', AdminController::class);
    });
});

// chi danh cho teacher
Route::middleware(['auth:teacher'])->group(function() {
    Route::prefix('teacher')->name('teacher.')->group(function() {
        Route::get('', [HomeTeacher::class, 'index'])
            ->name('dashboard');
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

Route::view('/test', 'auth.profiles.admin_profile');
