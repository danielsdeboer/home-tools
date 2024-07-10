<?php

namespace Database\Factories;

use App\Models\Bookmark;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Bookmark>
 */
class BookmarkFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name' => $this->faker->sentence(nbWords: rand(1, 4)),
			'url' => $this->faker->url(),
        ];
    }
}
