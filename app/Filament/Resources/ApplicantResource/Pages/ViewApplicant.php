<?php

declare(strict_types=1);

namespace App\Filament\Resources\ApplicantResource\Pages;

use App\Filament\Resources\ApplicantResource;
use Filament\Resources\Pages\ViewRecord;

final class ViewApplicant extends ViewRecord
{
    protected static string $resource = ApplicantResource::class;
}
