<?php


use App\Actions\Career\NotifyApplicantAction;
use App\Mail\ApplicantJudgementMail;
use App\Models\Career\Applicant;
use App\Models\Career\Position;
use App\Models\Career\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;

uses(RefreshDatabase::class);

it('sends an email to the hired applicant', function () {
    Mail::fake();
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
        'status' => 'hired',
    ]);
    $action = new NotifyApplicantAction();
    $action->handle($applicant);
    Mail::assertSent(ApplicantJudgementMail::class, function ($mail) use ($applicant) {
        return $mail->hasTo($applicant->email) && $mail->getStatus() === 'Hired';
    });
});
it('sends an email to the round2 applicant', function () {
    Mail::fake();
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
        'status' => 'round_2',
    ]);
    $action = new NotifyApplicantAction();
    $action->handle($applicant);
    Mail::assertSent(ApplicantJudgementMail::class, function ($mail) use ($applicant) {
        return $mail->hasTo($applicant->email) && $mail->getStatus() === 'Round 2';
    });
});
it('sends an email to the rejected applicant', function () {
    Mail::fake();
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
        'status' => 'rejected',
    ]);
    $action = new NotifyApplicantAction();
    $action->handle($applicant);
    Mail::assertSent(ApplicantJudgementMail::class, function ($mail) use ($applicant) {
        return $mail->hasTo($applicant->email) && $mail->getStatus() === 'Rejected';
    });
});
