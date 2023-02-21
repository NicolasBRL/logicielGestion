<?php

namespace Database\Factories;

use App\Models\Categorie;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Factory>
 */
class OperationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $categoriesId = [1, 3, 4, 5, 8];
        $date = $this->faker->dateTimeBetween('-1 years', 'now', 'Europe/Paris');

        return [
            'nom' => $this->faker->sentence(),
            'categorieId' => $this->faker->randomElement($categoriesId),
            'estCredit' => $this->faker->boolean(30),
            'montant' => $this->faker->randomNumber(2),
            'date' => $date,
            'created_at' => $date,
            'updated_at' => $date,
        ];
    }
}
