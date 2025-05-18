<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use App\Models\Report;
use App\Models\Feedback;
use Tests\TestCase;

class ReportFeedbackTest extends TestCase
{
    protected $user;
    protected $admin;
    protected $event;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $this->admin = User::factory()->create(['is_admin' => true]);
        $this->event = Event::factory()->create();
    }

    /** @test */
    public function user_can_create_report()
    {
        $this->actingAs($this->user);
        
        $reportData = [
            'description' => 'This event is inappropriate',
            'type' => 'spam'
        ];
        
        $response = $this->post(route('events.reports.store', $this->event), $reportData);
        
        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('reports', [
            'description' => 'This event is inappropriate',
            'type' => 'spam',
            'event_id' => $this->event->id,
            'user_id' => $this->user->id
        ]);
    }

    /** @test */
    public function admin_can_view_reports()
    {
        $this->actingAs($this->admin);
        
        // Create some reports
        Report::factory()->count(3)->create([
            'event_id' => $this->event->id
        ]);
        
        $response = $this->get(route('reports.index'));
        
        $response->assertStatus(200);
        $response->assertViewIs('reports.index');
        $response->assertViewHas('reports');
    }

    /** @test */
    public function admin_can_reject_report()
    {
        $this->actingAs($this->admin);
        
        $report = Report::factory()->create([
            'event_id' => $this->event->id
        ]);
        
        $response = $this->post(route('reports.reject'), [
            'report_id' => $report->id
        ]);
        
        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        // The report should be deleted
        $this->assertDatabaseMissing('reports', [
            'id' => $report->id
        ]);
    }

    /** @test */
    public function admin_can_block_event_from_report()
    {
        $this->actingAs($this->admin);
        
        $report = Report::factory()->create([
            'event_id' => $this->event->id
        ]);
        
        $response = $this->post(route('reports.block'), [
            'report_id' => $report->id
        ]);
        
        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        // The event status should be updated to 'blocked'
        $this->assertEquals('blocked', $this->event->fresh()->status);
        
        // The report should be deleted
        $this->assertDatabaseMissing('reports', [
            'id' => $report->id
        ]);
    }

    /** @test */
    public function user_can_create_feedback()
    {
        $this->actingAs($this->user);
        
        $feedbackData = [
            'subject' => 'Feature Request',
            'message' => 'Please add dark mode'
        ];
        
        $response = $this->post(route('feedbacks.store'), $feedbackData);
        
        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('feedbacks', [
            'subject' => 'Feature Request',
            'message' => 'Please add dark mode',
            'user_id' => $this->user->id,
            'is_resolved' => false
        ]);
    }

    /** @test */
    public function admin_can_mark_feedback_as_resolved()
    {
        $this->actingAs($this->admin);
        
        $feedback = Feedback::factory()->create([
            'user_id' => $this->user->id,
            'is_resolved' => false
        ]);
        
        $response = $this->patch(route('feedbacks.resolve', $feedback));
        
        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        $this->assertTrue($feedback->fresh()->is_resolved);
    }

    /** @test */
    public function regular_user_cannot_mark_feedback_as_resolved()
    {
        $this->actingAs($this->user);
        
        $feedback = Feedback::factory()->create([
            'user_id' => $this->user->id,
            'is_resolved' => false
        ]);
        
        $response = $this->patch(route('feedbacks.resolve', $feedback));
        
        $response->assertStatus(403);
        
        $this->assertFalse($feedback->fresh()->is_resolved);
    }
} 