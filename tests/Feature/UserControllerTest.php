<?php

namespace Tests\Feature;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        DB::delete('delete from users');
    }
    public function testLogin()
    {
        $this->get('/login')
            ->assertSeeText('Login');
    }

    public function testLoginPageForMember()
    {
        $this->withSession([
            'user' => 'daniel'
        ])->get('/login')
            ->assertRedirect('/');
    }

    public function testLoginSuccess()
    {
        $this->seed(UserSeeder::class);

        $this->post('/login', [
            'user' => 'daniel@gmail.com',
            'password' => 'rahasia'
        ])->assertRedirect('/')
            ->assertSessionHas('user', 'daniel@gmail.com');
    }

    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            'user' => 'daniel'
        ])->post('/login', [
            'user' => 'daniel',
            'password' => 'rahasia'
        ])->assertRedirect('/');
    }

    public function testLoginValidationError()
    {
        $this->post('/login', [])
            ->assertSeeText("User or password is required");
    }

    public function testLoginFailed()
    {
        $this->post('/login', [
            'user' => 'wrong',
            'password' => 'wrong'
        ])
            ->assertSeeText("User or password is wrong");
    }

    public function testLogout()
    {
        $this->withSession([
            'user' => 'daniel',
        ])->post('/logout')
            ->assertRedirect('/')
            ->assertSessionMissing("userr");
    }

    public function testLogoutGuest()
    {
        $this->post('/logout')
            ->assertRedirect('/');
    }
}
