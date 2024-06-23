<?php

namespace Database\Seeders;

use App\Models\Garden;
use Illuminate\Database\Seeder;

class GardenSeeder extends Seeder
{
    public function run(): void
    {
		Garden::factory()->count(50)->create();
    }
}
