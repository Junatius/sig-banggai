<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $start = $this->faker->dateTimeBetween('now', '+1 month');
        $end = (clone $start)->modify('+1 day');

        return [
            'users_id' => User::inRandomOrder()->first()->id ?? User::factory(),
            'name' => 'Festival ' . $this->faker->word(),
            'photo_url' => $this->faker->imageUrl('640', '480', 'event', true, 'Event'),
            'start_date' => $start,
            'end_date' => $end,
            'desc' => $this->faker->paragraph(2),
            'link' => $this->faker->optional()->url(),
            'manager' => $this->faker->name(),
            'contact' => '08' . rand(1000000000, 9999999999),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
