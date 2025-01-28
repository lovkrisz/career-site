<?php

declare(strict_types=1);

namespace App\Domain\Career\Traits;

use Illuminate\Support\Str;

trait UniqueSlugTrait
{
    public static function bootUniqueSlugTrait(): void
    {
        static::saving(function (self $model): void {
            $model->slug = $model->generateSlug($model->title);
        });
    }

    public function generateSlug(string $title): string
    {
        $slug = Str::slug($title, '-');
        $counter = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = Str::slug($title, '-').'-'.$counter;
            $counter++;
        }

        return $slug;

    }
}
