<?php

namespace App\Domain\Career\Controllers;

use App\Domain\Career\Models\Applicant;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ApplicantController extends Controller
{
    public function downloadCV(Applicant $applicant)
    {
        dd(Auth::user());
        $file = storage_path('app/private/' . $applicant->cv_url);
        if (file_exists($file)) {
            return response()->download($file);
        }
        abort(404);
    }
}
