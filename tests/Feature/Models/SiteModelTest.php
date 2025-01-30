<?php


use App\Models\Career\Position;
use App\Models\Career\Site;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);


test('positions returns HasMany instance', function () {
    $site = Site::create([
        'name' => 'Test Site',
    ]);
    expect($site->positions())->toBeInstanceOf(HasMany::class);
});

