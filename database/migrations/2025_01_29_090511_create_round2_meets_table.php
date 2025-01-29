<?php

declare(strict_types=1);

use App\Models\Career\Applicant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('round2_meets', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Applicant::class)->constrained('applicants');
            $table->dateTime('selected_datetime');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('round2_meets');
    }
};
