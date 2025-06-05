<?php

namespace Tests\Feature;

use App\Models\usuario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthLogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_puede_hacer_logout_correctamente()
    {
        // Crear un usuario
        $usuario = usuario::factory()->create([
            'password' => bcrypt('password123'), // asegurarse que la contraseña esté hasheada
        ]);

        // Autenticar al usuario para el test y crear token
        Sanctum::actingAs($usuario, ['*']);

        // Llamar al endpoint logout
        $response = $this->postJson('/api/logout');

        // Comprobar que responde con mensaje correcto
        $response->assertStatus(200)
                 ->assertJson([
                     'mensaje' => 'Sesión cerrada correctamente.'
                 ]);

        // Comprobar que los tokens del usuario fueron revocados (tabla personal_access_tokens vacía)
        $usuario->refresh();
        $this->assertCount(0, $usuario->tokens);
    }

    
}
