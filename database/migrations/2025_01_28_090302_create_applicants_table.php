<?php

use App\Domain\Career\Models\Position;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	public function up(): void
	{
		Schema::create('applicants', function (Blueprint $table) {
			$table->id();
			$table->string('name');
			$table->string('email');
			$table->string('mobile');
			$table->foreignId('position_id')->constrained();
			$table->string('cv_url');
			$table->integer('wage')->nullable();
			$table->longText('introduction')->nullable();
			$table->string('residence')->nullable();
			$table->dateTime('birthdate')->nullable();
			$table->json('position_specific_questions')->nullable();
            $table->string('status')->default('pending');
			$table->timestamps();

            $table->unique(['position_id', 'email']);
		});
	}

};
