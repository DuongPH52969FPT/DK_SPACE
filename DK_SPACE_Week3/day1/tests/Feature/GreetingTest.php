<?php

namespace Tests\Feature;

use Tests\TestCase;

class GreetingTest extends TestCase
{
    public function test_greeting_in_vietnamese()
    {
        // Set locale là 'vi'
        config(['app.locale' => 'vi']);

        $response = $this->get('/greeting');

        $response->assertStatus(200);
        $response->assertSeeText('Xin chào, quản trị viên');
    }

    public function test_greeting_in_english()
    {
        // Set locale là 'en'
        config(['app.locale' => 'en']);

        $response = $this->get('/greeting');

        $response->assertStatus(200);
        $response->assertSeeText('Hello, admin');
    }
}
