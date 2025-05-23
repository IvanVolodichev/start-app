<?php

namespace Tests\Unit;

use App\Models\Report;
use App\Models\Event;
use App\Models\User;
use Tests\TestCase;

class ReportTest extends TestCase
{
    /** @test */
    public function it_has_correct_fillable_attributes()
    {
        $report = new Report();
        $this->assertEquals([
            'message',
            'user_id',
            'event_id',
            'status',
            'resolved_at'
        ], $report->getFillable());
    }
    
    /** @test */
    public function it_belongs_to_event()
    {
        $report = new Report();
        
        $this->assertTrue(method_exists($report, 'event'));
    }
    
    /** @test */
    public function it_belongs_to_user()
    {
        $report = new Report();
        
        $this->assertTrue(method_exists($report, 'user'));
    }
    
    /** @test */
    public function event_relationship_returns_belongs_to_relationship()
    {
        $report = new Report();
        
        $relation = $report->event();
        
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Relations\BelongsTo',
            $relation
        );
    }
    
    /** @test */
    public function user_relationship_returns_belongs_to_relationship()
    {
        $report = new Report();
        
        $relation = $report->user();
        
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Relations\BelongsTo',
            $relation
        );
    }
    
    /** @test */
    public function it_can_be_created_with_required_attributes()
    {
        $report = new Report([
            'message' => 'Test report message',
            'user_id' => 1,
            'event_id' => 1,
            'status' => 'pending'
        ]);
        
        $this->assertEquals('Test report message', $report->message);
        $this->assertEquals(1, $report->user_id);
        $this->assertEquals(1, $report->event_id);
        $this->assertEquals('pending', $report->status);
    }
} 