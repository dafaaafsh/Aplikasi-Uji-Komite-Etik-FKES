<?php

namespace Database\Factories;

use App\Models\protocols;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\keputusan>
 */
class keputusanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'protokol_id' => protocols::factory(),
            'hasil_akhir' => fake()->randomElement(['Diterima','Ditolak']),
            'keterangan' => fake()->sentence(10)
        ];
    }
}
