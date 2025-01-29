<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Actions\Calendar\CreateCalendarEntryAction;
use App\Models\Career\Applicant;
use App\Models\GoogleCalendar\Calendar;
use Livewire\Component;

final class CalendarComponent extends Component
{
    public string $selectedDate;

    public string $selectedTime;

    public string $successMessage = '';

    public Applicant $applicant;

    public function selectDateTime(string $date, string $time): void
    {
        $this->selectedDate = $date;
        $this->selectedTime = $time;

        app(CreateCalendarEntryAction::class)->handle($this->applicant, $date, $time);

        $this->successMessage = 'You have successfully selected the date, we will send you a calendar invite shortly.';
    }

    public function render()
    {

        $dates = Calendar::where('available_times', '!=', null)
            ->get();

        return view('livewire.calendar-component', ['dates' => $dates]);
    }
}
