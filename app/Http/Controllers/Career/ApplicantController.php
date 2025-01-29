<?php

declare(strict_types=1);

namespace App\Http\Controllers\Career;

use App\Http\Controllers\Controller;
use App\Models\Career\Applicant;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class ApplicantController extends Controller
{
    public function downloadCV(Applicant $applicant): BinaryFileResponse
    {

        $file = storage_path('app/private/'.$applicant->cv_url);
        if (file_exists($file)) {
            return response()->download($file);
        }
        abort(404);
    }

    public function interviewCalendar(Applicant $applicant): View
    {
        return view('calendar.index', ['applicant' => $applicant]);
    }
}
