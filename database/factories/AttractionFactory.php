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
            'desc' => $this->faker->paragraph(),
            'has_facility' => $this->faker->boolean(70),
            'type' => $this->faker->randomElement($types),
            'legality' => 'Surat Izin No. ' . rand(1000, 9999) . '/SI',
            'contact' => '08' . rand(1000000000, 9999999999),
        ];
    }
}
