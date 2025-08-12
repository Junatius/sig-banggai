<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'users_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'title' => $this->faker->sentence(6),
            'photo_url' => $this->faker->optional()->imageUrl(640, 480, 'news', true, 'News'),
            'desc' => $this->faker->sentence(12),
        ];
    }
}
