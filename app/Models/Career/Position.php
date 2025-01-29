<?php

declare(strict_types=1);

namespace App\Models\Career;

use App\Http\Traits\UniqueSlugTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

final class Position extends Model
{
    use UniqueSlugTrait;

    protected $fillable = [
        'site_id',
        'title',
        'description',
        'position_specific_questions',
        'slug',
    ];

    protected $casts = [
        'position_specific_questions' => 'array',
    ];

    public function site(): BelongsTo
    {
        return $this->belongsTo(Site::class);
    }

    public function applicants(): HasMany
    {
        return $this->hasMany(Applicant::class);
    }
}
