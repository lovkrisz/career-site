<?php

declare(strict_types=1);

namespace App\Http\Traits;

use Illuminate\Support\Str;

trait UniqueSlugTrait
{
    /**
     * Bootstrap the UniqueSlugTrait.
     *
     * When the model is creating, automatically generate a slug based on the title.
     */
    public static function bootUniqueSlugTrait(): void
    {
        static::creating(function (self $model): void {
            // Generate a slug based on the title and check for uniqueness
            $model->slug = $model->generateSlug($model->title);
        });
    }

    /**
     * Generate a unique slug from the given title.
     */
    public function generateSlug(string $title): string
    {
        $slug = Str::slug($title, '-');
        $counter = 1;

        // Check if the given slug already exists
        while (static::where('slug', $slug)->exists()) {
            // If exists, append a counter to the slug
            $slug = Str::slug($title, '-').'-'.$counter;
            $counter++;
        }

        return $slug;
    }
}
