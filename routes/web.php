<?php

declare(strict_types=1);

use App\Domain\Career\Controllers\ApplicantController;
use App\Domain\Career\Controllers\PositionApplyController;
use App\Domain\Career\Controllers\PositionController;
use Illuminate\Support\Facades\Route;
use Spatie\GoogleCalendar\Event;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/teszt', function () {
    Event::create([
        'name' => 'A new event',
        'startDateTime' => Carbon\Carbon::now(),
        'endDateTime' => Carbon\Carbon::now()->addHour(),
    ]);
});

Route::redirect('/login', '/admin/login')->name('login');

Route::resource('position', PositionController::class)->only(['index', 'show'])->parameters([
    'position' => 'position:slug',
]);
Route::get('/applicant/downloadCV/{applicant}', [ApplicantController::class, 'downloadCV'])->name('applicants.download')->middleware('auth');
Route::get('/position/apply/{position}', [PositionApplyController::class, 'index'])->name('position.apply');
Route::post('/position/apply/store/{position:slug}', [PositionApplyController::class, 'store'])->name('position.apply.store');
Route::get('/applicant/interview/calendar/{applicant}', [ApplicantController::class, 'interviewCalendar'])->name('applicant.interview.calendar');
