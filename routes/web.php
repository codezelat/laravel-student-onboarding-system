<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DiplomaRegistrationController;
use App\Http\Controllers\DegreeRegistrationController;
use App\Http\Controllers\AdminDiplomaController;
use App\Http\Controllers\AdminDegreeController;
use App\Http\Controllers\ExamPaperSubmissionController;

Route::get('/', function () {
    return view('welcome');
});

Route::match(['get', 'post'], '/register', function () {
    return redirect('/login');
});

Route::get('/admin/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'is_admin'])->name('dashboard');


// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

Route::get('/diploma-register', [DiplomaRegistrationController::class, 'create'])->name('diploma.register');
Route::post('/diploma-register', [DiplomaRegistrationController::class, 'store'])->name('diploma.register.store');

Route::get('/diploma-register/{registerId}', [DiplomaRegistrationController::class, 'show'])->name('diploma.register.show');

Route::get('/degree-register', [DegreeRegistrationController::class, 'create'])->name('degree.register');
Route::post('/degree-register', [DegreeRegistrationController::class, 'store'])->name('degree.register.store');

Route::get('/degree-register/{registerId}', [DegreeRegistrationController::class, 'show'])->name('degree.register.show');

Route::get('/submit-exam-paper', [ExamPaperSubmissionController::class, 'create'])->name('exam.paper.create');
Route::post('/submit-exam-paper', [ExamPaperSubmissionController::class, 'store'])->name('exam.paper.store');

Route::middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/admin/diploma-registrations', [AdminDiplomaController::class, 'index'])->name('admin.registrations');
    Route::get('/admin/export-diploma-registrations', [AdminDiplomaController::class, 'export'])->name('admin.registrations.export');
    Route::delete('/admin/diploma-registrations/{id}', [AdminDiplomaController::class, 'destroy'])->name('admin.registrations.destroy');
    Route::get('/admin/degree-registrations', [AdminDegreeController::class, 'index'])->name('admin.degree_registrations');
    Route::get('/admin/export-degree-registrations', [AdminDegreeController::class, 'export'])->name('admin.degree_registrations.export');
    Route::delete('/admin/degree-registrations/{id}', [AdminDegreeController::class, 'destroy'])->name('admin.degree_registrations.destroy');
    Route::get('/admin/exam-paper-submissions', [ExamPaperSubmissionController::class, 'adminIndex'])->name('admin.exam.index');
    Route::get('/admin/exam-paper-submissions/{id}/download', [ExamPaperSubmissionController::class, 'adminDownload'])->name('admin.exam.download');
    Route::delete('/admin/exam-paper-submissions/{id}', [ExamPaperSubmissionController::class, 'adminDestroy'])->name('admin.exam.destroy');
});

require __DIR__.'/auth.php';
