<?php

use App\Models\Career\Position;
use App\Models\Career\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;


uses(RefreshDatabase::class);

it('generates slug when creating instance', function () {
    $site = Site::create([
        "name" => "Test Site"
    ])->id;
    $position = Position::create([
        'site_id' => $site,
        'title' => 'Test Title',
        'description' => 'Test Description',
    ]);
    expect($position->slug)->toBe("test-title");
});
it('adds counter data when slug already exists', function () {
    $site = Site::create([
        "name" => "Test Site"
    ])->id;
    $position1 = Position::create([
        'site_id' => $site,
        'title' => 'Test Title',
        'description' => 'Test Description',
    ]);
    $position2 = Position::create([
        'site_id' => $site,
        'title' => 'Test Title',
        'description' => 'Test Description',
    ]);
    expect($position2->slug)->toBe("test-title-1")
        ->and($position1->slug)->toBe("test-title");
});
