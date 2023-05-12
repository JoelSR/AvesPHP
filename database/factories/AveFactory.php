<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AveFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

    protected $model = Ave::class;
    
    public function definition()
    {
        return [
            'nombre' => $this->faker->unique()->word(),
            'nombre_ingles' => $this->faker->unique()->word(),
            'nombre_latin' => $this->faker->unique()->word(),
            'url' => $this->faker->url(),
            'fecha_registro' => now()->toDateString(),
        ];
    }
}
