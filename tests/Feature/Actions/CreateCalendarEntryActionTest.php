<?php

use App\Models\Career\Applicant;
use App\Models\Career\Position;
use App\Models\Career\Site;
use App\Models\GoogleCalendar\Calendar;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Actions\Calendar\CreateCalendarEntryAction;

uses(RefreshDatabase::class);

it('creates an entry', function () {
    $site = Site::create([
        "name" => "Test Site"
    ])->id;
    $position = Position::create([
        'site_id' => $site,
        'title' => 'Test Title',
        'description' => 'Test Description',
    ])->id;
    $applicant = Applicant::create([
        'name' => 'Test Name',
        'email' => 'email@example.com',
        'mobile' => '1234567890',
        'position_id' => $position,
        'cv_url' => '/path/to/cv.pdf',
    ]);
    $calendar = Calendar::create([
        'date' => '2025-06-01',
        'available_times' => '10:00,11:00'
    ]);

    $interviewDate = '2025-06-01';
    $interviewTime = '10:00';


    $action = new CreateCalendarEntryAction();
    $action->handle($applicant, '2025-06-01', '10:00');


    $cal = Calendar::where('date', '=', '2025-06-01')->first();

    expect($applicant->interview_datetime)->toEqual(Carbon::parse($interviewDate . ' ' . $interviewTime))
        ->and($cal->used_times)->toBe("10:00");

});
