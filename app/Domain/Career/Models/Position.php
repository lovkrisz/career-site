<?php

namespace App\Domain\Career\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Str;

class Position extends Model
{
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
    public static function generateSlug($title): string
    {
        $slug = Str::slug($title);
        $originalSlg = $slug;
        $counter = 1;

        while(Position::where('slug', $slug)->exists()) {
            $slug = "{$originalSlg}-{$counter}";
            $counter++;
        }
        return $slug;
    }
}
