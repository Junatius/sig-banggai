<?php

namespace Database\Factories;

use App\Models\Subdistrict;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Attraction>
 */
class AttractionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['Desa', 'Warga', 'Pemerintah', 'Pribadi', 'Lainnya'];

        return [
            'subdistrict_id' => Subdistrict::inRandomOrder()->first()->id ?? Subdistrict::factory(),
            'name' => 'Wisata ' . $this->faker->city(),
            'photo_profile' => $this->faker->imageUrl('640', '480', 'nature', true, 'Attraction'),
            'latitude' => $this->faker->latitude(-3.5, 1.5),
            'longitude' => $this->faker->longitude(119.0, 124.0),
            'desc' => $this->faker->paragraph(),
            'has_facility' => $this->faker->boolean(70),
            'type' => $this->faker->randomElement($types),
            'legality' => 'Surat Izin No. ' . rand(1000, 9999) . '/SI',
            'price' => $this->faker->numberBetween(10000, 50000),
        ];
    }
}
