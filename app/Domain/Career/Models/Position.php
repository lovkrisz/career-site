<?php

namespace App\Domain\Career\Models;

use App\Domain\Career\Traits\UniqueSlugTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Str;

class Position extends Model
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
        'position_specific_questions' => 'array'
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
