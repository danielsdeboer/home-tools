<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plots', function (Blueprint $table) {
            $table->uuid()->primary();
			$table->uuid('garden_uuid');
			$table->uuid('plant_uuid');
			$table->string('name');
			$table->text('description')->nullable();
			$table->date('planted_at');
			$table->date('germinated_at')->nullable();
			$table->date('harvested_at')->nullable();
            $table->timestamps();
			$table->softDeletes();

			$table->foreign('garden_uuid')->references('uuid')->on('gardens');
			$table->foreign('plant_uuid')->references('uuid')->on('plants');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plots');
    }
};
