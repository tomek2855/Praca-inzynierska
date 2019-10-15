<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class LoginTest extends TestCase
{
    public function testLogin()
    {
        factory(User::class)->create([
            'name' => 'admin',
            'password' => Hash::make('admin'),
        ]);

        $response = $this->json('POST', '/api/login');
        $response->assertStatus(422);

        $response = $this->json('POST', '/api/login', [
            'user' => 'admin',
            'password' => '123456',
        ]);
        $response->assertStatus(422);

        $response = $this->json('POST', '/api/login', [
            'user' => 'admin',
            'password' => 'admin'
        ]);
        $response->assertStatus(200);
        $response->assertJsonStructure(['token']);
    }
}
