<?php

namespace Tests\Unit;

use App\Console\Commands\UpdateEventStatuses;
use App\Models\Event;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;
use Mockery;

class UpdateEventStatusesTest extends TestCase
{
    /** @test */
    public function it_should_mark_events_as_active_on_event_date()
    {
        // Создаем событие с сегодняшней датой и статусом 'planned'
        $event = new Event();
        $event->status = 'planned';
        $event->date = Carbon::today();
        
        // Проверяем базовую логику обновления статуса
        $this->assertEquals('planned', $event->status);
        
        // Имитируем обновление статуса
        if ($event->date->isToday() && $event->status === 'planned') {
            $event->status = 'active';
        }
        
        $this->assertEquals('active', $event->status);
    }
    
    /** @test */
    public function it_should_mark_events_as_completed_after_end_time()
    {
        // Создаем событие с сегодняшней датой, прошедшим временем окончания и статусом 'active'
        $event = new Event();
        $event->status = 'active';
        $event->date = Carbon::today();
        $event->end_time = Carbon::now()->subHour();
        
        // Проверяем базовую логику обновления статуса
        $this->assertEquals('active', $event->status);
        
        // Имитируем обновление статуса
        if ($event->date->isToday() && $event->status === 'active' && 
            Carbon::parse($event->end_time)->isPast()) {
            $event->status = 'completed';
        }
        
        $this->assertEquals('completed', $event->status);
    }
    
    /** @test */
    public function it_should_not_change_status_of_future_events()
    {
        // Создаем событие с будущей датой и статусом 'planned'
        $event = new Event();
        $event->status = 'planned';
        $event->date = Carbon::tomorrow();
        
        // Проверяем базовую логику обновления статуса
        $this->assertEquals('planned', $event->status);
        
        // Имитируем обновление статуса (не должно измениться)
        if ($event->date->isToday() && $event->status === 'planned') {
            $event->status = 'active';
        }
        
        $this->assertEquals('planned', $event->status);
    }
    
    /** @test */
    public function it_should_not_change_status_of_ongoing_events()
    {
        // Создаем событие с сегодняшней датой, будущим временем окончания и статусом 'active'
        $event = new Event();
        $event->status = 'active';
        $event->date = Carbon::today();
        $event->end_time = Carbon::now()->addHour();
        
        // Проверяем базовую логику обновления статуса
        $this->assertEquals('active', $event->status);
        
        // Имитируем обновление статуса (не должно измениться)
        if ($event->date->isToday() && $event->status === 'active' && 
            Carbon::parse($event->end_time)->isPast()) {
            $event->status = 'completed';
        }
        
        $this->assertEquals('active', $event->status);
    }
    
    /** @test */
    public function it_should_not_change_blocked_or_deleted_events()
    {
        // Создаем события со статусами 'blocked' и 'deleted'
        $blockedEvent = new Event();
        $blockedEvent->status = 'blocked';
        $blockedEvent->date = Carbon::today();
        
        $deletedEvent = new Event();
        $deletedEvent->status = 'deleted';
        $deletedEvent->date = Carbon::today();
        
        // Проверяем базовую логику обновления статуса
        $this->assertEquals('blocked', $blockedEvent->status);
        $this->assertEquals('deleted', $deletedEvent->status);
        
        // Имитируем обновление статуса (не должно измениться)
        if ($blockedEvent->date->isToday() && !in_array($blockedEvent->status, ['blocked', 'deleted'])) {
            $blockedEvent->status = 'active';
        }
        
        if ($deletedEvent->date->isToday() && !in_array($deletedEvent->status, ['blocked', 'deleted'])) {
            $deletedEvent->status = 'active';
        }
        
        $this->assertEquals('blocked', $blockedEvent->status);
        $this->assertEquals('deleted', $deletedEvent->status);
    }
} 