<?php

declare(strict_types=1);

namespace App\Filament\Resources\CalendarResource\Pages;

use App\Filament\Resources\CalendarResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateCalendar extends CreateRecord
{
    protected static string $resource = CalendarResource::class;
}
