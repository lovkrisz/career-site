<?php

declare(strict_types=1);

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Site extends Model
{
    protected $fillable = [
        'name',
    ];

    public function positions(): HasMany
    {
        return $this->hasMany(Position::class);
    }
}
