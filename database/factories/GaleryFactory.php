<?php

namespace Database\Factories;

use App\Models\Attraction;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Galery>
 */
class GaleryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'attractions_id' => Attraction::inRandomOrder()->first()->id ?? Attraction::factory(),
            'users_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'photo_url' => $this->faker->imageUrl('640', '480', 'nature', true, 'Gallery'),
            'status' => $this->faker->randomElement(['pending', 'rejected', 'approved']),
        ];
    }
}
