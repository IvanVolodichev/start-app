<?php

namespace Tests\Unit;

use App\Models\User;
use Tests\TestCase;

class UserMethodsTest extends TestCase
{
    /** @test */
    public function user_has_is_admin_attribute()
    {
        $user = new User();
        
        // Проверяем наличие аксессора или метода
        $this->assertTrue(
            method_exists($user, 'getIsAdminAttribute') || 
            method_exists($user, 'isAdmin')
        );
    }
    
    /** @test */
    public function user_can_determine_if_has_joined_event()
    {
        $user = new User();
        
        // Проверяем наличие метода hasJoinedEvent
        $this->assertTrue(
            method_exists($user, 'hasJoinedEvent') || 
            method_exists(get_parent_class($user), 'hasJoinedEvent')
        );
    }
    
    /** @test */
    public function user_can_get_avatar_url()
    {
        $user = new User();
        
        // Проверяем наличие метода avatarUrl или соответствующего аксессора
        $this->assertTrue(
            method_exists($user, 'avatarUrl') || 
            method_exists($user, 'getAvatarUrlAttribute')
        );
    }
    
    /** @test */
    public function user_models_use_has_factory_trait()
    {
        $userClass = new \ReflectionClass(User::class);
        $this->assertTrue($userClass->hasMethod('factory'));
    }
    
    /** @test */
    public function user_can_check_if_owns_event()
    {
        $user = new User();
        
        // Проверяем наличие метода ownsEvent
        $this->assertTrue(
            method_exists($user, 'ownsEvent') || 
            method_exists(get_parent_class($user), 'ownsEvent')
        );
    }
} 