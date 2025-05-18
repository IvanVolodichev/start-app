<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SampleTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertRedirect('/main');
    }
    
    /**
     * Test that a simple assertion works.
     */
    public function test_simple_assertion(): void
    {
        $this->assertTrue(true);
    }
}
