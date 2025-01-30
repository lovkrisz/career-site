<?php


use App\Models\GoogleCalendar\Calendar;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('has available times', function () {
    $date = now()->format('Y-m-d');
    Calendar::create([
        'date' => $date,
        'available_times' => "15:00, 16:00, 17:00"
    ]);

    expect(Calendar::hasAvailableTimes($date))->toBeTrue();


});
it('returns false when date does not exists', function () {
    expect(Calendar::hasAvailableTimes('2001-01-01'))->toBeFalse();
});
it('returns empty array when date does not exists', function () {
    expect(Calendar::getAvailableTimesOnDate('2001-01-01'))->toBeEmpty();
});
it('gets the available times', function () {
    $date = now()->format('Y-m-d');
    Calendar::create([
        'date' => $date,
        'available_times' => '15:00,16:00,17:00',
        'used_times' => '15:00',
    ]);

    expect(Calendar::getAvailableTimesOnDate($date))->toEqual(['16:00', '17:00']);
});
