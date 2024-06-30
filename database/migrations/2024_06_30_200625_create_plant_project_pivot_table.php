<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plant_project', function (Blueprint $table) {
			$table->foreignUuid('plant_uuid')
				->references('uuid')
				->on('plants');
			$table->foreignUuid('project_uuid')
				->references('uuid')
				->on('projects');

			$table->unique(['plant_uuid', 'project_uuid']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plant_project');
    }
};
