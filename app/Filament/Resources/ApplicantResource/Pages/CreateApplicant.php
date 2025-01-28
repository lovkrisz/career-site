<?php

declare(strict_types=1);

namespace App\Filament\Resources\ApplicantResource\Pages;

use App\Filament\Resources\ApplicantResource;
use Filament\Resources\Pages\CreateRecord;

final class CreateApplicant extends CreateRecord
{
    protected static string $resource = ApplicantResource::class;
}
