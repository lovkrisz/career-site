<?php

use App\Domain\Career\Controllers\ApplicantController;
use App\Domain\Career\Controllers\PositionApplyController;
use App\Domain\Career\Controllers\PositionController;
use App\Domain\Career\Models\Position;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::redirect('/login', '/admin/login')->name('login');

Route::resource('position', PositionController::class)->parameters([
    'position' => 'position:slug'
]);
Route::get('/applicant/downloadCV/{applicant}', [ApplicantController::class, 'downloadCV'])->name('applicants.download')->middleware('auth');
Route::get('/position/apply/{position}', [PositionApplyController::class, 'index'])->name('position.apply');
Route::post('/position/apply/store/{position:slug}', [PositionApplyController::class, 'store'])->name('position.apply.store');
