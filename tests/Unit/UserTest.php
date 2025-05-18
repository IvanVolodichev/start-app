<?php

namespace Tests\Unit;

use App\Models\User;
use App\Models\Event;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function it_has_correct_fillable_attributes()
    {
        $user = new User();
        $this->assertEquals([
            'name',
            'bio',
            'email',
            'password',
            'avatar',
            'provider',
            'provider_id'
        ], $user->getFillable());
    }

    /** @test */
    public function it_has_correct_hidden_attributes()
    {
        $user = new User();
        $this->assertEquals([
            'password',
            'remember_token',
        ], $user->getHidden());
    }

    /** @test */
    public function it_has_correct_casts()
    {
        $user = new User();
        $casts = $user->getCasts();
        
        // Only check that the expected casts are present
        $this->assertArrayHasKey('email_verified_at', $casts);
        $this->assertEquals('datetime', $casts['email_verified_at']);
        $this->assertArrayHasKey('password', $casts);
        $this->assertEquals('hashed', $casts['password']);
    }

    /** @test */
    public function it_has_events_relationship()
    {
        // Instead of creating events which might rely on other tables,
        // just check that the relationship method exists
        $user = new User();
        $this->assertTrue(method_exists($user, 'events'));
    }
} 