<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\program>
 */
class programFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'sumber_dana' => $this->faker->name(),
            'data_program' => $this->faker->name(),
            'keterangan' => $this->faker->name()
        ];
    }
}
