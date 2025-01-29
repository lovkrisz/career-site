<?php

namespace App\Domain\Career\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Round2Meets extends Model
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
