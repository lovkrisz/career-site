<?php


use App\Http\Controllers\Career\PositionApplyController;
use App\Models\Career\Position;
use App\Models\Career\Site;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\View\View;

uses(RefreshDatabase::class);

test('index returns view with position', function () {
    // Create a position with a slug
    $site = Site::create([
        "name" => "Test Site"
    ])->id;
    $position = Position::create([
        'site_id' => $site,
        'title' => 'Test Title',
        'description' => 'Test Description',
    ]);

    // Call the index function with the slug
    $response = (new PositionApplyController)->index('test-title');

    // Assert that the response is a view with the position
    expect($response)->toBeInstanceOf(View::class)
        ->and($response->getData()['position']->id)->toBe($position->id);
});
test('validation fails when required fields are missing', function () {
    $site = Site::create([
        "name" => "Test Site"
    ])->id;
    $position = Position::create([
        'site_id' => $site,
        'title' => 'Test Title',
        'description' => 'Test Description',
    ]);

    $response = $this->post(route('position.apply.store', $position->slug), [
        'name' => '',
        'email' => '',
        'mobile' => '',
        'cv' => '',
        'wage' => '',
        'introduction' => '',
        'residence' => '',
        'birthdate' => '',
    ]);

    $response->assertSessionHasErrors(['name', 'email', 'mobile', 'cv']);
});

