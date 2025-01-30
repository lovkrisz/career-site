<?php


use App\Models\Career\Position;
use App\Models\Career\Site;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('site returns belongs to relationship', function () {
    $site = Site::create([
        "name" => "Test Site"
    ])->id;
    $position = Position::create([
        'site_id' => $site,
        'title' => 'Test Title',
        'description' => 'Test Description',
    ]);
    expect($position->site())->toBeInstanceOf(BelongsTo::class);
});
test('Applicants returns HasMany instance', function () {
    $site = Site::create([
        "name" => "Test Site"
    ])->id;
    $position = Position::create([
        'site_id' => $site,
        'title' => 'Test Title',
        'description' => 'Test Description',
    ]);
    expect($position->applicants())->toBeInstanceOf(HasMany::class);
});
