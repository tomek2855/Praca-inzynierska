<?php

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\Passport;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    public function testLogout()
    {
        $response = $this->json('POST', '/api/logout');
        $response->assertStatus(401);

        $user = factory(User::class)->create();
        Passport::actingAs($user);

        $response = $this->json('POST', '/api/logout');
        $response->assertStatus(200);
    }
}
