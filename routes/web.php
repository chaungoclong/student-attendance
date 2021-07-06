<?php

use App\Http\Controllers\Admin\HomeController as HomeAdmin;
use App\Http\Controllers\Teacher\HomeController as HomeTeacher;
use App\Http\Controllers\HomeController as Home;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GradeController;
use App\Http\Controllers\SubjectController;

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
});

// chi danh cho admin
Route::middleware(['auth:admin'])->group(function() {
    Route::prefix('admin')->name('admin.')->group(function() {
        Route::get('', [HomeAdmin::class, 'index'])
            ->name('dashboard');
    });
    Route::resource('grade', GradeController::class);
    Route::resource('subject', SubjectController::class);
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
