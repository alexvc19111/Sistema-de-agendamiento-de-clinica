<?php
namespace Database\Factories;

use App\Models\usuario;
use App\Models\persona;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class UsuarioFactory extends Factory
{
    protected $model = usuario::class;

    public function definition()
    {
        return [
            'username' => $this->faker->unique()->userName,
            'password' => bcrypt('password123'), // Contraseña por defecto para pruebas
            'persona_id' => persona::factory(),  // Crea una persona relacionada
        ];
    }
}