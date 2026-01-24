<?php

use Illuminate\Support\Facades\Route;

use Illuminate\Http\Request;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\InstitueClassController;
use App\Http\Controllers\ClassSectionController;
use App\Http\Controllers\NoticeBoardController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\StudentSchoolDataController;
use App\Models\StudentSchoolData;

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

Route::get('/', function () {
    // return view('welcome');
    return redirect(route('login'));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\InstitutionController::class, 'dashboard'])->name('home');

Route::resource('institutions', InstitutionController::class);
Route::resource('institute_classes', InstitueClassController::class);
Route::get('/class-students/{id}', [InstitueClassController::class, 'classStudents'])->name('getClassStudents');
Route::resource('class_sections', ClassSectionController::class);
Route::resource('student_profiles', StudentProfileController::class);
Route::get('/students', [StudentProfileController::class, 'index'])->name('students.index');

Route::resource('notice_boards', NoticeBoardController::class);
Route::post('/addstudentclass', [StudentProfileController::class, 'addData'])->name('addstudentclass');
Route::resource('student_school_data', StudentSchoolDataController::class);
Route::get('/getsection/{id}', [ClassSectionController::class, 'index'])->name('getsection');
Route::post('/addsection', [ClassSectionController::class, 'create'])->name('addsection');
Route::post('/sendGenNotice', [NoticeBoardController::class, 'sendGenNotice'])->name('sendGenNotice');
Route::get('/student-notice/{id}', [NoticeBoardController::class, 'noticepage'])->name('noticepage');
Route::post('/sendStudentNotice', [NoticeBoardController::class, 'sendStudentNotice'])->name('sendStudentNotice');
Route::get('/class-notice/{id}', [NoticeBoardController::class, 'classnoticepage'])->name('classnoticepage');
Route::post('/classStudentNotice', [NoticeBoardController::class, 'classStudentNotice'])->name('classStudentNotice');
Route::get('/classNoticeReport', [NoticeBoardController::class, 'classnoticereport'])->name('classnoticereport');

Route::post('/students/import', [StudentProfileController::class, 'importExcel'])->name('students.import');
Route::get('/students/template', [StudentProfileController::class, 'downloadStudentTemplate']) ->name('students.template');
Route::get('/get-sections/{classId}', [StudentProfileController::class, 'getSections'])->name('get.sections');
Route::get('/students/{id}/edit', [StudentProfileController::class, 'edit'])->name('students.edit');
Route::put('/students/{id}', [StudentProfileController::class, 'update'])->name('students.update');



