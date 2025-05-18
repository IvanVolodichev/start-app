<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthTest extends TestCase
{
    /** @test */
    public function login_page_can_be_rendered()
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);
    }

    /** @test */
    public function register_page_can_be_rendered()
    {
        $response = $this->get(route('register'));
        $response->assertStatus(200);
    }

    /** @test */
    public function users_can_authenticate()
    {
        $user = User::factory()->create([
            'password' => Hash::make('password')
        ]);
        
        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);
        
        $this->assertAuthenticated();
        $response->assertRedirect('/main');
    }

    /** @test */
    public function users_cannot_authenticate_with_invalid_password()
    {
        $user = User::factory()->create();
        
        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);
        
        $this->assertGuest();
    }
    
    /** @test */
    public function users_can_register()
    {
        $response = $this->post(route('register'), [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        
        $this->assertAuthenticated();
        $response->assertRedirect('/main');
        
        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
    
    /** @test */
    public function users_can_logout()
    {
        $user = User::factory()->create();
        
        $this->actingAs($user);
        $this->assertAuthenticated();
        
        $response = $this->post(route('logout'));
        
        $this->assertGuest();
        $response->assertRedirect('/');
    }
    
    /** @test */
    public function user_can_request_password_reset()
    {
        $user = User::factory()->create();
        
        $response = $this->post(route('password.email'), [
            'email' => $user->email,
        ]);
        
        $response->assertSessionHas('status');
    }
    
    /** @test */
    public function user_can_view_password_reset_form()
    {
        $user = User::factory()->create();
        
        $token = Password::createToken($user);
        
        $response = $this->get(route('password.reset', $token));
        
        $response->assertStatus(200);
    }
    
    /** @test */
    public function user_can_update_password()
    {
        $user = User::factory()->create();
        
        $token = Password::createToken($user);
        
        $response = $this->post(route('password.store'), [
            'token' => $token,
            'email' => $user->email,
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);
        
        $response->assertSessionHasNoErrors();
    }
} 