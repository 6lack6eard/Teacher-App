<?php

use App\Http\Controllers\TeacherController;
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

Route::get('/', [TeacherController::class, 'index'])->name('index');
Route::post('/teacher-login', [TeacherController::class, 'login'])->name('teacher.login');
Route::middleware('auth:teacher')->group(function() {
    Route::get('/logout', [TeacherController::class, 'logout'])->name('teacher.logout');
    Route::get('/dashboard', [TeacherController::class, 'dashboard'])->name('teacher.dashboard');
    Route::post('/add-student-marks', [TeacherController::class, 'addStudentMarks'])->name('student.add.marks');
    Route::post('/edit-student-marks', [TeacherController::class, 'editStudentMarks'])->name('student.edit.marks');
    Route::post('/delete-student-marks', [TeacherController::class, 'deleteStudentMarks'])->name('student.delete.marks');
});
