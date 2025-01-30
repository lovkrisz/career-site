<?php

declare(strict_types=1);

use App\Http\Controllers\Career\PositionController;
use App\Models\Career\Position;
use App\Models\Career\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\View\View;

uses(RefreshDatabase::class);

test('index returns a view', function () {
    $controller = new PositionController();
    $response = $controller->index();
    expect($response)->toBeInstanceOf(View::class);
});

test('show method returns a view', function () {
    $site = Site::create([
        'name' => 'Test Site',
    ])->id;
    $position = Position::create([
        'site_id' => $site,
        'title' => 'Test Title',
        'description' => 'Test Description',
    ]);
    $response = new PositionController()->show($position);
    expect($response)->toBeInstanceOf(View::class);
});
