<?php

namespace Tests\Feature\Http;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class HomePageTest extends TestCase
{
    public function testGetHomePage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
