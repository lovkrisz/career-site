<?php

declare(strict_types=1);

use App\Models\Career\Applicant;
use App\Models\Career\Position;
use App\Models\Career\Site;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('position returns belongs to relationship', function () {
    $site = Site::create([
        'name' => 'Test Site',
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
    expect($applicant->position())->toBeInstanceOf(BelongsTo::class);
});
