<?php

namespace Tests\Unit;

use App\Models\Sport;
use App\Models\Event;
use Tests\TestCase;

class SportTest extends TestCase
{
    /** @test */
    public function it_has_correct_fillable_attributes()
    {
        $sport = new Sport();
        $this->assertEquals([
            'name'
        ], $sport->getFillable());
    }
    
    /** @test */
    public function it_has_events_relationship()
    {
        $sport = new Sport();
        
        // Проверяем, существует ли метод events() или определен в родительском классе
        $this->assertTrue(method_exists($sport, 'events') || 
                        method_exists(get_parent_class($sport), 'events'));
    }
    
    /** @test */
    public function it_can_be_created_with_name()
    {
        $sport = new Sport(['name' => 'Футбол']);
        
        $this->assertEquals('Футбол', $sport->name);
    }
    
    /** @test */
    public function it_uses_has_factory_trait()
    {
        $sportClass = new \ReflectionClass(Sport::class);
        $this->assertTrue($sportClass->hasMethod('factory'));
    }
} 