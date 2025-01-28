<?php

use App\Domain\Career\Controllers\PositionApplyController;
use App\Domain\Career\Controllers\PositionController;
use App\Domain\Career\Models\Position;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {


    return view('welcome');
});

Route::resource('position', PositionController::class)->parameters([
    'position' => 'position:slug'
]);
Route::get('/position/apply/{position}', [PositionApplyController::class, 'index'])->name('position.apply');
Route::post('/position/apply/store/{position:slug}', [PositionApplyController::class, 'store'])->name('position.apply.store');
