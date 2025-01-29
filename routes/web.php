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

Route::get('/teszt', function () {
    $date = '2021-10-10';
    $time = '10:00';
    $interviewTime = Carbon::parse($date.' '.$time);
    $endTime = $interviewTime->copy()->addHour();
    dd($interviewTime->format('Y-m-d H:i').' - '.$endTime->format('Y-m-d H:i'));
});

Route::redirect('/login', '/admin/login')->name('login');

Route::resource('position', PositionController::class)->only(['index', 'show'])->parameters([
    'position' => 'position:slug',
]);
Route::get('/applicant/downloadCV/{applicant}', [ApplicantController::class, 'downloadCV'])->name('applicants.download')->middleware('auth');
Route::get('/position/apply/{position}', [PositionApplyController::class, 'index'])->name('position.apply');
Route::post('/position/apply/store/{position:slug}', [PositionApplyController::class, 'store'])->name('position.apply.store');
Route::get('/applicant/interview/calendar/{applicant}', [ApplicantController::class, 'interviewCalendar'])->name('applicant.interview.calendar');
