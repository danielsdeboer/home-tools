<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('links', function (Blueprint $table) {
			$table->uuid()->primary();
			$table->string('link');
			$table->text('description')->nullable();
			$table->uuid('linkable_uuid');
			$table->string('linkable_type');
			$table->timestamps();
			$table->softDeletes();
		});
    }

    public function down(): void
    {
        Schema::dropIfExists('links');
    }
};
