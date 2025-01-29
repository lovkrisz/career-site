<?php

declare(strict_types=1);

namespace App\Domain\Career\Controllers;

use App\Domain\Career\Models\Applicant;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use View;

final class ApplicantController extends Controller
{
    public function downloadCV(Applicant $applicant): BinaryFileResponse
    {

        $file = storage_path('app/private/' . $applicant->cv_url);
        if (file_exists($file)) {
            return response()->download($file);
        }
        abort(404);
    }

    public function interviewCalendar(): View
    {
        return view('applicant.interview-calendar');
    }
}
