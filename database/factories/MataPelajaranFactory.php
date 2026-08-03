<?php

namespace Database\Factories;

use App\Models\MataPelajaran;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MataPelajaran>
 */
class MataPelajaranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Menghasilkan nama pelajaran unik dengan kombinasi kata & angka unik agar muat 500 data
            'nama_pelajaran' => fake()->unique()->words(2, true) . ' ' . fake()->numberBetween(1, 999),
        ];
    }
}
