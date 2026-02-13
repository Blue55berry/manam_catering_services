<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminLoginTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        
        Admin::create([
            'name' => 'adminuser',
            'email' => 'admin@test.com',
            'password' => bcrypt('password123'),
        ]);
    }

    public function test_admin_can_login_with_email()
    {
        $response = $this->post(route('admin.login'), [
            'login' => 'admin@test.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs(Admin::where('email', 'admin@test.com')->first(), 'admin');
    }

    public function test_admin_can_login_with_username()
    {
        $response = $this->post(route('admin.login'), [
            'login' => 'adminuser',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs(Admin::where('name', 'adminuser')->first(), 'admin');
    }

    public function test_admin_cannot_login_with_invalid_credentials()
    {
        $response = $this->post(route('admin.login'), [
            'login' => 'wronguser',
            'password' => 'wrongpassword',
        ]);

        $response->assertSessionHasErrors('login');
        $this->assertGuest('admin');
    }
}
