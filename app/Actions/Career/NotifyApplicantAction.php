<?php

declare(strict_types=1);

namespace App\Actions\Career;

use App\Mail\ApplicantJudgementMail;
use App\Models\Career\Applicant;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;

final class NotifyApplicantAction
{
    /**
     * Handle the notification process for an applicant.
     */
    public function handle(Applicant $applicant): void
    {
        $interviewUrl = '';
        switch ($applicant->status) {
            case 'hired':
                $mailStatus = 'Hired';
                break;
            case 'round_2':
                $mailStatus = 'Round 2';
                $interviewUrl = URL::temporarySignedRoute('applicant.interview.calendar', now()->addDays(15), ['applicant' => $applicant]);
                break;
            default:
                $mailStatus = 'Rejected';
                break;
        }

        Mail::to($applicant->email)->send(new ApplicantJudgementMail($applicant, $mailStatus, $interviewUrl));
    }
}
