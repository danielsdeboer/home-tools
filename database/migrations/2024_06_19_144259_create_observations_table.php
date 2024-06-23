<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('observations', function (Blueprint $table) {
            $table->uuid()->primary();
			$table->text('content');
			$table->dateTime('observed_at');
			$table->string('status');
			$table->uuid('observable_uuid');
			$table->string('observable_type');
			$table->timestamps();
			$table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('observations');
    }
};
