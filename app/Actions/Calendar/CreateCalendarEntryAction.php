<?php

declare(strict_types=1);

namespace App\Actions\Calendar;

use App\Models\Career\Applicant;
use App\Models\GoogleCalendar\Calendar;
use Carbon\Carbon;
use Spatie\GoogleCalendar\Event;

final class CreateCalendarEntryAction
{
    /**
     * Handle the creation of a calendar entry for an applicant's interview.
     *
     * @param  Applicant  $applicant  The applicant object.
     * @param  string  $interviewDate  The date of the interview.
     * @param  string  $interviewTime  The time of the interview.
     */
    public function handle(Applicant $applicant, string $interviewDate, string $interviewTime): void
    {
        $interviewDateTime = Carbon::parse($interviewDate.' '.$interviewTime);
        $event = new Event();
        $event->name = 'Round2 interview with '.$applicant->name;
        $event->startDateTime = $interviewDateTime;
        $event->endDateTime = $interviewDateTime->copy()->addHour();
        $event->addAttendee([
            'email' => $applicant->email,
            'name' => $applicant->name,
            'responseStatus' => 'needsAction',
        ]);
        $event->addMeetLink();
        $event->save();

        $calendar = Calendar::firstOrCreate([
            'date' => $interviewDate,
        ], [
            'used_times' => '',
        ]);

        $usedTimes = array_merge(
            explode(',', $calendar->used_times ?? ''),
            [$interviewTime],
        );

        $calendar->update([
            'used_times' => implode(',', array_unique($usedTimes)),
        ]);
    }
}
