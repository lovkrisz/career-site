<?php

declare(strict_types=1);

use App\Http\Controllers\Career\ApplicantController;
use App\Http\Controllers\Career\PositionApplyController;
use App\Http\Controllers\Career\PositionController;
use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/login', '/admin/login')->name('login');

Route::resource('position', PositionController::class)->only(['index', 'show'])->parameters([
    'position' => 'position:slug',
]);
Route::get('/applicant/downloadCV/{applicant}', [ApplicantController::class, 'downloadCV'])->name('applicants.download')->middleware('auth');
Route::get('/position/apply/{position}', [PositionApplyController::class, 'index'])->name('position.apply');
Route::post('/position/apply/store/{position:slug}', [PositionApplyController::class, 'store'])->name('position.apply.store');
Route::get('/applicant/interview/calendar/{applicant}', [ApplicantController::class, 'interviewCalendar'])->name('applicant.interview.calendar');

