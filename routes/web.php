<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\HomeController;
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
 
// chi danh cho user(admin, teacher)
Route::middleware(['auth:admin,teacher'])->group(function() {
    // dashboard
    Route::get('/dashboard', [HomeController::class, 'index'])
        ->name('dashboard');

    // logout
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
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


// route cho guest
Route::middleware(['guest:admin,teacher'])->group(function() {
    Route::get('/', [HomeController::class, 'welcome'])->name('welcome');
});
