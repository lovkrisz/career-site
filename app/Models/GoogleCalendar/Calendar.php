<?php

declare(strict_types=1);

namespace App\Models\GoogleCalendar;

use Illuminate\Database\Eloquent\Model;

final class Calendar extends Model
{
    protected $fillable = [
        'date',
        'available_times',
        'used_times',
    ];

    /**
     * Checks if there are any available times on a given date.
     *
     * @param  string  $date  the date in the format 'Y-m-d'
     * @return bool true if there are available times, false otherwise
     */
    public static function hasAvailableTimes(string $date): bool
    {
        $times = self::where('date', $date)->first();
        if ($times) {
            // Get the available and used times and explode them into arrays
            $available_times = $times->available_times;
            $used_times = $times->used_times;
            $used_times = explode(',', (string) $used_times);
            $available_times = explode(',', (string) $available_times);

            // Calculate the difference between the two arrays
            $diff = array_diff($available_times, $used_times);

            // Return true if there are available times, false otherwise
            return $diff !== [];
        }

        return false;
    }

    /**
     * Return the available times for a given date.
     *
     * @param  string  $date  the date in the format 'Y-m-d'
     * @return array the available times in the format ['09:00', '10:00', ...]
     */
    public static function getAvailableTimesOnDate(string $date): array
    {
        $times = self::where('date', $date)->first();
        if ($times) {
            // Get the available and used times and explode them into arrays
            $available_times = $times->available_times;
            $used_times = $times->used_times;
            $used_times = explode(',', (string) $used_times);
            $available_times = explode(',', (string) $available_times);

            // Return the difference between the available times and the used times
            return array_values(array_diff($available_times, $used_times));
        }

        // Return an empty array if no times were found
        return [];
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
