<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plant_plot', function (Blueprint $table) {
            $table->uuid('plant_uuid');
			$table->uuid('plot_uuid');

			$table->unique(['plant_uuid', 'plot_uuid']);
			$table->foreign('plant_uuid')->references('uuid')->on('plants');
			$table->foreign('plot_uuid')->references('uuid')->on('plots');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plant_plot');
    }
};
