<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test que un usuario autenticado puede acceder al dashboard
     */
    public function test_authenticated_user_can_access_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/dashboard');

        $response->assertStatus(200);
    }

    /**
     * Test que un usuario no autenticado es redirigido al login
     */
    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect(route('login'));
    }

    /**
     * Test que la ruta raíz redirige correctamente según el estado de autenticación
     */
    public function test_home_route_redirects_authenticated_user_to_dashboard(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/');

        $response->assertRedirect(route('dashboard'));
    }

    /**
     * Test que la ruta raíz redirige usuarios no autenticados al login
     */
    public function test_home_route_redirects_guest_to_login(): void
    {
        $response = $this->get('/');

        $response->assertRedirect(route('login'));
    }
}
