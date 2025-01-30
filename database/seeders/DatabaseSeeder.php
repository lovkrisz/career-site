<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Auth\User;
use App\Models\Career\Position;
use App\Models\Career\Site;
use Illuminate\Database\Seeder;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

final class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        Site::create([
            'name' => 'Dunaföldvár',
        ]);
        Site::create([
            'name' => 'Budapest',
        ]);
        Site::create([
            'name' => 'Székesfehérvár',
        ]);

        Position::create([
            'site_id' => 1,
            'title' => 'Senior PHP Developer',
            'description' => 'We are looking for a Senior PHP Developer to join our team.',
            'position_specific_questions' => json_encode([
                [
                    'text' => 'What is your experience with laravel?',
                    'format' => 'input-text',
                    'name' => 'laravel_experience',
                    'required' => true,
                ],
                [
                    'text' => 'What is your experience with vue.js?',
                    'format' => 'select',
                    'options' => ['1', '2', '3', '4'],
                    'name' => 'vue_experience',
                    'required' => false,
                ],
            ]),
        ]);
        Position::create([
            'site_id' => 2,
            'title' => 'Junior PHP Developer',
            'description' => 'We are looking for a Junior PHP Developer to join our team.',

        ]);
        Position::create([
            'site_id' => 3,
            'title' => 'Senior Frontend Developer',
            'description' => 'We are looking for a Senior Frontend Developer to join our team.',

        ]);

    }
}
