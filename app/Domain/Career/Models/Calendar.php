<?php

namespace App\Domain\Career\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Calendar extends Model
{
    protected $fillable = [
        'date',
        'available_times',
        'used_times',
    ];

    public function getDateAttribute($date)
    {
        return Carbon::createFromFormat('Y-m-d', $date);
    }

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'available_times' => 'array',
            'used_times' => 'array',
        ];
    }
}
