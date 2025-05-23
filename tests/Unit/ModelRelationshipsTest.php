<?php

namespace Tests\Unit;

use App\Models\Event;
use App\Models\User;
use App\Models\Sport;
use App\Models\Report;
use App\Models\Participant;
use App\Models\Feedback;
use Tests\TestCase;

class ModelRelationshipsTest extends TestCase
{
    /** @test */
    public function user_can_have_many_events()
    {
        $user = new User();
        $relation = $user->events();
        
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Relations\HasMany',
            $relation
        );
        $this->assertEquals('user_id', $relation->getForeignKeyName());
    }
    
    /** @test */
    public function event_belongs_to_user_as_author()
    {
        $event = new Event();
        $relation = $event->author();
        
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Relations\BelongsTo',
            $relation
        );
        $this->assertEquals('user_id', $relation->getForeignKeyName());
    }
    
    /** @test */
    public function event_belongs_to_sport()
    {
        $event = new Event();
        $relation = $event->sport();
        
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Relations\BelongsTo',
            $relation
        );
        $this->assertEquals('sport_id', $relation->getForeignKeyName());
    }
    
    /** @test */
    public function event_has_many_participants()
    {
        $event = new Event();
        $relation = $event->participants();
        
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Relations\HasMany',
            $relation
        );
        $this->assertEquals('event_id', $relation->getForeignKeyName());
    }
    
    /** @test */
    public function event_has_many_reports()
    {
        $event = new Event();
        $relation = $event->reports();
        
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Relations\HasMany',
            $relation
        );
        $this->assertEquals('event_id', $relation->getForeignKeyName());
    }
} 