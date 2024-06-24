<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('plots', function (Blueprint $table) {
			$table->dropForeign('plots_plant_uuid_foreign');

            $table->dropColumn('plant_uuid');
        });
    }

    public function down(): void
    {
        Schema::table('plots', function (Blueprint $table) {
            $table->uuid('plant_uuid')->nullable();
        });
    }
};
