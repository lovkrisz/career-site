<?php

declare(strict_types=1);

use App\Models\Career\Site;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('positions', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Site::class)->constrained();
            $table->string('title');
            $table->longText('description');
            $table->json('position_specific_questions')->nullable();
            $table->string('slug');
            $table->timestamps();
        });
    }
};
