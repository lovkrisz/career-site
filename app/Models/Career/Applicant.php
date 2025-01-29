<?php

declare(strict_types=1);

namespace App\Models\Career;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Applicant extends Model
{
    protected $fillable = [
        'name',
        'email',
        'mobile',
        'position_id',
        'cv_url',
        'wage',
        'introduction',
        'residence',
        'birthdate',
        'position_specific_questions',
        'status',
    ];

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class);
    }

    protected function casts(): array
    {
        return [
            'birtdate' => 'datetime',
            'job_specific_questions' => 'array',
        ];
    }
}
