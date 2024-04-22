<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'supplier_type' => 'pf',
            'cpf' => fake()->numerify('###########'),
            'personal_name' => fake()->name(),
            'nickname' => fake()->name(),
            'rg' => fake()->numerify('########'),
            'active' => true,
            'note' => fake()->text(70),
        ];
    }
}
