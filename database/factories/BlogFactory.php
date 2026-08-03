<?php

namespace Database\Factories;

use App\Models\Blog;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title'   => fake()->sentence(6),
            'content' => fake()->paragraphs(3, true),
            'author'  => fake()->name(),
            'date'    => fake()->date(),
        ];
    }
}
