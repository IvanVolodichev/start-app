<?php

namespace Tests\Unit;

use App\Models\Feedback;
use App\Models\User;
use Tests\TestCase;

class FeedbackTest extends TestCase
{
    /** @test */
    public function it_has_correct_fillable_attributes()
    {
        $feedback = new Feedback();
        $this->assertEquals([
            'message',
            'user_id',
            'status',
            'resolved_at',
        ], $feedback->getFillable());
    }
    
    /** @test */
    public function it_belongs_to_user()
    {
        $feedback = new Feedback();
        
        $this->assertTrue(method_exists($feedback, 'user'));
    }
    
    /** @test */
    public function user_relationship_returns_belongs_to_relationship()
    {
        $feedback = new Feedback();
        
        $relation = $feedback->user();
        
        $this->assertInstanceOf(
            'Illuminate\Database\Eloquent\Relations\BelongsTo',
            $relation
        );
    }
    
    /** @test */
    public function it_has_correct_table_name()
    {
        $feedback = new Feedback();
        $this->assertEquals('feedbacks', $feedback->getTable());
    }
    
    /** @test */
    public function it_has_correct_casts()
    {
        $feedback = new Feedback();
        $casts = $feedback->getCasts();
        
        $this->assertArrayHasKey('resolved_at', $casts);
        $this->assertEquals('datetime:Y-m-d H:i:s', $casts['resolved_at']);
    }
    
    /** @test */
    public function it_can_be_created_with_required_attributes()
    {
        $feedback = new Feedback([
            'message' => 'Test feedback message',
            'user_id' => 1,
            'status' => 'pending'
        ]);
        
        $this->assertEquals('Test feedback message', $feedback->message);
        $this->assertEquals(1, $feedback->user_id);
        $this->assertEquals('pending', $feedback->status);
    }
} 