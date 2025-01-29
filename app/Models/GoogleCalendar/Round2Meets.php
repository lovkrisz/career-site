<?php

declare(strict_types=1);

namespace App\Models\GoogleCalendar;

use App\Models\Career\Applicant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

final class Round2Meets extends Model
{
    protected $fillable = [
        'applicant_id',
        'selected_datetime',
    ];

    public function applicant(): BelongsTo
    {
        return $this->belongsTo(Applicant::class);
    }

    protected function casts(): array
    {
        return [
            'selected_datetime' => 'datetime',
        ];
    }
}
