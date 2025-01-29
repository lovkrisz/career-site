<?php

namespace App\Domain\Career\Actions;

use App\Domain\Career\Mail\ApplicantJudgementMail;
use App\Domain\Career\Models\Applicant;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

class NotifyApplicantAction
{
    public function handle(Applicant $applicant): void
    {
        $status = $applicant->status;
        $url = "";
        if ($status === 'hired') {
            $mailStatus = 'Hired';
        } elseif ($status === 'round_2') {
            $mailStatus = 'Round 2';
            $url = URL::temporarySignedRoute('applicant.interview.calendar', now()->addDays(15), ['applicant' => $applicant]);
        } else {
            $mailStatus = 'Rejected';
        }


        Mail::to($applicant->email)->send(new ApplicantJudgementMail($applicant, $mailStatus, $url));
    }
}
