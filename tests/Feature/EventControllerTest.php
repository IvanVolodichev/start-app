<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use App\Models\Sport;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EventControllerTest extends TestCase
{
    use WithFaker;

    protected $user;
    protected $sport;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create a user and sport for tests
        $this->user = User::factory()->create();
        $this->sport = Sport::factory()->create();

        // Mock the storage disk
        Storage::fake('reg');
    }

    /** @test */
    public function unauthenticated_users_cannot_access_event_management()
    {
        $this->get(route('events.create'))->assertRedirect(route('login'));
        $this->post(route('events.store'))->assertRedirect(route('login'));
        
        $event = Event::factory()->create();
        $this->get(route('events.edit', $event))->assertRedirect(route('login'));
        $this->put(route('events.update', $event))->assertRedirect(route('login'));
        $this->delete(route('events.destroy', $event))->assertRedirect(route('login'));
    }

    /** @test */
    public function user_can_view_events_index()
    {
        $events = Event::factory()->count(3)->create();
        
        $response = $this->get(route('events.index'));
        
        $response->assertStatus(200);
        $response->assertViewIs('events.index');
        $response->assertViewHas('events');
    }

    /** @test */
    public function user_can_view_event_details()
    {
        $event = Event::factory()->create();
        
        $response = $this->get(route('events.show', $event));
        
        $response->assertStatus(200);
        $response->assertViewIs('events.show');
        $response->assertViewHas('event');
    }

    /** @test */
    public function authenticated_user_can_create_event()
    {
        $this->actingAs($this->user);
        
        $response = $this->get(route('events.create'));
        $response->assertStatus(200);
        $response->assertViewIs('events.create');
        
        $eventData = [
            'title' => 'Test Event',
            'max_participant' => 20,
            'date' => now()->addDay()->format('Y-m-d'),
            'start_time' => '12:00',
            'end_time' => '14:00',
            'comment' => 'Test comment',
            'address' => 'Test address',
            'latitude' => '55.7558',
            'longitude' => '37.6173',
            'sport_id' => $this->sport->id,
            'images' => [
                UploadedFile::fake()->image('event1.jpg'),
                UploadedFile::fake()->image('event2.jpg')
            ]
        ];
        
        $response = $this->post(route('events.store'), $eventData);
        
        $response->assertRedirect();
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('events', [
            'title' => 'Test Event',
            'user_id' => $this->user->id,
            'sport_id' => $this->sport->id
        ]);
    }

    /** @test */
    public function user_can_edit_their_own_event()
    {
        $this->actingAs($this->user);
        
        $event = Event::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'planned' // Not active to allow editing
        ]);
        
        $response = $this->get(route('events.edit', $event));
        $response->assertStatus(200);
        $response->assertViewIs('events.edit');
        
        $updatedData = [
            'title' => 'Updated Event Title',
            'max_participant' => 25,
            'date' => now()->addDays(2)->format('Y-m-d'),
            'start_time' => '13:00',
            'end_time' => '15:00',
            'comment' => 'Updated comment',
            'address' => 'Updated address',
            'latitude' => '55.7558',
            'longitude' => '37.6173',
            'sport_id' => $this->sport->id
        ];
        
        $response = $this->put(route('events.update', $event), $updatedData);
        
        $response->assertRedirect(route('events.show', $event));
        $response->assertSessionHas('success');
        
        $this->assertDatabaseHas('events', [
            'id' => $event->id,
            'title' => 'Updated Event Title',
            'max_participant' => 25
        ]);
    }

    /** @test */
    public function user_cannot_edit_active_event()
    {
        $this->actingAs($this->user);
        
        $event = Event::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'active'
        ]);
        
        $response = $this->get(route('events.edit', $event));
        $response->assertRedirect(route('events.show', $event));
        $response->assertSessionHasErrors('error');
        
        $updatedData = [
            'title' => 'Updated Event Title',
            'max_participant' => 25,
            'date' => now()->addDays(2)->format('Y-m-d'),
            'start_time' => '13:00',
            'end_time' => '15:00',
            'comment' => 'Updated comment',
            'address' => 'Updated address',
            'latitude' => '55.7558',
            'longitude' => '37.6173',
            'sport_id' => $this->sport->id
        ];
        
        $response = $this->put(route('events.update', $event), $updatedData);
        
        $response->assertRedirect(route('events.show', $event));
        $response->assertSessionHasErrors('error');
    }

    /** @test */
    public function user_can_delete_their_own_event()
    {
        $this->actingAs($this->user);
        
        $event = Event::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'planned'
        ]);
        
        $response = $this->delete(route('events.destroy', $event));
        
        $response->assertRedirect(route('events.my'));
        $response->assertSessionHas('success');
        
        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }

    /** @test */
    public function user_cannot_delete_active_event()
    {
        $this->actingAs($this->user);
        
        $event = Event::factory()->create([
            'user_id' => $this->user->id,
            'status' => 'active'
        ]);
        
        $response = $this->delete(route('events.destroy', $event));
        
        $response->assertRedirect(route('events.show', $event));
        $response->assertSessionHasErrors('error');
        
        $this->assertDatabaseHas('events', ['id' => $event->id]);
    }

    /** @test */
    public function user_can_view_their_events()
    {
        $this->actingAs($this->user);
        
        Event::factory()->count(3)->create(['user_id' => $this->user->id]);
        
        $response = $this->get(route('events.my'));
        
        $response->assertStatus(200);
        $response->assertViewIs('events.my');
        $response->assertViewHas('events');
    }

    /** @test */
    public function event_search_and_filters_work()
    {
        // Create test data
        $sport = Sport::factory()->create(['name' => 'Basketball']);
        
        Event::factory()->create([
            'title' => 'Basketball Game',
            'sport_id' => $sport->id,
            'max_participant' => 15
        ]);
        
        // Test search
        $response = $this->get(route('events.index', ['search' => 'Basketball']));
        $response->assertStatus(200);
        $this->assertStringContainsString('Basketball', $response->getContent());
        
        // Test sport filter
        $response = $this->get(route('events.index', ['sport' => $sport->id]));
        $response->assertStatus(200);
        
        // Test participant filter
        $response = $this->get(route('events.index', ['participants' => 'over_10']));
        $response->assertStatus(200);
    }
} 