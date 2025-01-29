<?php

namespace App\Domain\Career\Actions;

use App\Domain\Career\Mail\ApplicantJudgementMail;
use App\Domain\Career\Models\Applicant;
use Illuminate\Support\Facades\Mail;

class NotifyApplicantAction
{
    public function handle(Applicant $applicant): void
    {
        $status = $applicant->status;
        if ($status === 'hired') {
            $mailStatus = 'Hired';
        } elseif ($status === 'round_2') {
            $mailStatus = 'Round 2';
        } else {
            $mailStatus = 'Rejected';
        }


        Mail::to($applicant->email)->send(new ApplicantJudgementMail($applicant, $mailStatus));
    }
}
