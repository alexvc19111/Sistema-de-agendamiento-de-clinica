<?php

namespace Database\Factories;

use App\Models\persona;
use Illuminate\Database\Eloquent\Factories\Factory;

class PersonaFactory extends Factory
{
    protected $model = persona::class;

    public function definition(): array
    {
        return [
            'nombres' => $this->faker->firstName,
            'apellidos' => $this->faker->lastName,
            'dni' => $this->faker->unique()->numerify('##########'),
            'fecha_nacimiento' => $this->faker->date(),
            'direccion' => $this->faker->address,
            'telefono' => $this->faker->phoneNumber,
        ];
    }
}
