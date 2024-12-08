<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Mockery\Undefined;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_login_with_valid_credentials()
    {
        // Membuat user untuk pengujian
        $user = \App\Models\User::factory()->create([
            'email' => 'user@example.com',
            'password' => bcrypt('password123'),
        ]);

        // Mengirim permintaan POST ke route login dengan kredensial valid
        $response = $this->post(route('login'), [
            'email' => 'user@example.com',
            'password' => 'password123',
        ]);

        // Memastikan user diarahkan ke halaman dashboard setelah login
        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }

    public function test_login_with_empty_credentials()
    {
        $response = $this->post(route('login'), [
            'email' => '',
            'password' => '',
        ]);

        // Memastikan validasi gagal dan pesan kesalahan ditampilkan
        $response->assertSessionHasErrors(['email', 'password']);
    }

    public function test_login_with_invalid_credentials()
    {
        $response = $this->post(route('login'), [
            'email' => 'wrong@example.com',
            'password' => 'wrongpassword',
        ]);

        // Memastikan login gagal dan user tidak diautentikasi
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_login_with_inactive_account()
    {
        // Membuat user yang tidak aktif
        $user = \App\Models\User::factory()->create([
            'email' => 'inactive@example.com',
            'password' => bcrypt('password123'),
            'is_active' => false,
        ]);

        // Mencoba login dengan akun yang tidak aktif
        $response = $this->post(route('login'), [
            'email' => 'inactive@example.com',
            'password' => 'password123',
            'is_active'=>false,
        ]);

        // Memastikan login gagal karena akun tidak aktif
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_brute_force_attack()
    {
        $user = \App\Models\User::factory()->create([
            'email' => 'user2@example.com',
            'password' => bcrypt('password123'),
        ]);

        for ($i = 0; $i < 5; $i++) {
            $response = $this->post(route('login'), [
                'email' => 'user2@example.com',
                'password' => 'wrongpassword',
            ]);

            $response->assertSessionHasErrors('email');
        }

        $this->assertGuest();
    }
}
