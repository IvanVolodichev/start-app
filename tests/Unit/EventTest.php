<?php

namespace Tests\Unit;

use App\Models\Event;
use App\Models\User;
use App\Models\Sport;
use App\Models\Report;
use App\Models\Participant;
use Tests\TestCase;

class EventTest extends TestCase
{
    /** @test */
    public function it_has_correct_fillable_attributes()
    {
        $event = new Event();
        $this->assertEquals([
            'title',
            'max_participant',
            'current_participant',
            'date',
            'start_time',
            'end_time',
            'comment',
            'address',
            'latitude',
            'longitude',
            'status',
            'user_id',
            'sport_id',
            'cloud_folder',
        ], $event->getFillable());
    }

    /** @test */
    public function it_has_sport_relationship()
    {
        $event = new Event();
        $this->assertTrue(method_exists($event, 'sport'));
    }

    /** @test */
    public function it_has_author_relationship()
    {
        $event = new Event();
        $this->assertTrue(method_exists($event, 'author'));
    }

    /** @test */
    public function it_has_reports_relationship()
    {
        $event = new Event();
        $this->assertTrue(method_exists($event, 'reports'));
    }

    /** @test */
    public function it_has_participants_relationship()
    {
        $event = new Event();
        $this->assertTrue(method_exists($event, 'participants'));
    }

    /** @test */
    public function it_has_correct_casts()
    {
        $event = new Event();
        $casts = $event->getCasts();
        
        // Check expected casts are present
        $this->assertArrayHasKey('date', $casts);
        $this->assertEquals('datetime:Y-m-d', $casts['date']);
        $this->assertArrayHasKey('start_time', $casts);
        $this->assertEquals('datetime:H:i', $casts['start_time']);
        $this->assertArrayHasKey('end_time', $casts);
        $this->assertEquals('datetime:H:i', $casts['end_time']);
    }
} 