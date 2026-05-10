<?php

namespace Database\Factories;

use App\Models\Theme;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Livre>
 */
class LivreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'codeL'=>fake()->unique()->countryCode(),
            'titre'=> fake()->userName(),
            'auteur'=> fake()->firstName(),
            'nbExemplaire'=> fake()->numberBetween(1,200),
            'theme_id'=> Theme::factory(),
        ];
    }
}
