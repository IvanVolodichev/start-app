<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use App\Models\Participant;
use Tests\TestCase;

class ParticipantControllerTest extends TestCase
{
    protected $user;
    protected $event;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->user = User::factory()->create();
        $eventOwner = User::factory()->create();
        
        $this->event = Event::factory()->create([
            'user_id' => $eventOwner->id,
            'max_participant' => 10,
            'current_participant' => 5,
            'status' => 'planned'
        ]);
    }

    /** @test */
    public function guest_cannot_join_event()
    {
        $response = $this->post(route('events.participants.store', $this->event));
        
        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_user_can_join_event()
    {
        $this->actingAs($this->user);
        
        $response = $this->post(route('events.participants.store', $this->event));
        
        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('participants', [
            'user_id' => $this->user->id,
            'event_id' => $this->event->id,
            'status' => 'planned'
        ]);
        
        // Verify the event's current_participant count was incremented
        $this->assertEquals(6, $this->event->fresh()->current_participant);
    }

    /** @test */
    public function user_cannot_join_full_event()
    {
        $this->actingAs($this->user);
        
        // Update event to be full
        $this->event->update([
            'max_participant' => 5,
            'current_participant' => 5
        ]);
        
        $response = $this->post(route('events.participants.store', $this->event));
        
        $response->assertRedirect();
        $response->assertSessionHasErrors();
        
        $this->assertDatabaseMissing('participants', [
            'user_id' => $this->user->id,
            'event_id' => $this->event->id
        ]);
    }

    /** @test */
    public function user_cannot_join_blocked_or_deleted_event()
    {
        $this->actingAs($this->user);
        
        // Update event to be blocked
        $this->event->update(['status' => 'blocked']);
        
        $response = $this->post(route('events.participants.store', $this->event));
        
        $response->assertRedirect();
        $response->assertSessionHasErrors();
        
        // Update event to be deleted
        $this->event->update(['status' => 'deleted']);
        
        $response = $this->post(route('events.participants.store', $this->event));
        
        $response->assertRedirect();
        $response->assertSessionHasErrors();
    }

    /** @test */
    public function user_can_leave_event()
    {
        $this->actingAs($this->user);
        
        // First join the event
        $participant = Participant::factory()->create([
            'user_id' => $this->user->id,
            'event_id' => $this->event->id,
            'status' => 'planned'
        ]);
        
        // Update event count
        $this->event->update(['current_participant' => 6]);
        
        $response = $this->delete(route('events.participants.destroy', [
            'event' => $this->event,
            'participant' => $participant
        ]));
        
        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        $this->assertDatabaseMissing('participants', [
            'id' => $participant->id,
            'status' => 'planned'
        ]);
        
        // Verify the event's current_participant count was decremented
        $this->assertEquals(5, $this->event->fresh()->current_participant);
    }
} 