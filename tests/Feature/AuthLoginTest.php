<?php

namespace Tests\Feature;

use App\Models\usuario;
use App\Models\persona;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthLoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_puede_iniciar_sesion_correctamente()
    {
        $persona = persona::factory()->create();
        $user = usuario::create([
            'username' => 'prueba_user',
            'password' => Hash::make('password123'),
            'persona_id' => $persona->id,
        ]);

        $response = $this->postJson('/api/login', [
            'username' => 'prueba_user',
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'id',
                     'token',
                     'username',
                     'persona',
                     'roles',
                 ]);
    }
}
