<?php

use App\Actions\Career\CreatePositionApplicationAction;
use App\Models\Career\Position;
use App\Models\Career\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

uses(RefreshDatabase::class);
it('creates a new applicant', function () {

    $site = Site::create([
        "name" => "Test Site"
    ])->id;
    $position = Position::create([
        'site_id' => $site,
        'title' => 'Test Title',
        'description' => 'Test Description',
    ]);

    $validatedData = [
        'name' => 'John Doe',
        'email' => 'LX7Ml@example.com',
        'mobile' => '1234567890',
        'cv' => UploadedFile::fake()->create('test.pdf'),
        'wage' => '1000',
        'introduction' => 'Test Introduction',
        'residence' => 'Test Residence',
        'birthdate' => '1990-01-01',

    ];
    $rules = json_encode([""]);
    $action = new CreatePositionApplicationAction();
    $action->handle($validatedData, $rules, $position);

    $this->assertDatabaseHas('applicants', [
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'mobile' => $validatedData['mobile'],
        'wage' => $validatedData['wage'],
        'introduction' => $validatedData['introduction'],
        'residence' => $validatedData['residence'],
        'birthdate' => $validatedData['birthdate'],
        'position_specific_questions' => $rules,
        'status' => 'pending',
    ]);

});
