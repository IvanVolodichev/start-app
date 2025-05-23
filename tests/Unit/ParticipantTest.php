<?php

namespace Tests\Unit;

use App\Models\Participant;
use App\Models\Event;
use App\Models\User;
use Tests\TestCase;

class ParticipantTest extends TestCase
{
    /** @test */
    public function it_has_correct_fillable_attributes()
    {
        $participant = new Participant();
        $this->assertEquals([
            'event_id',
            'user_id'
        ], $participant->getFillable());
    }
    
    /** @test */
    public function it_belongs_to_event()
    {
        $participant = new Participant();
        
        // Проверяем, существует ли метод event()
        $this->assertTrue(method_exists($participant, 'event') || 
                        method_exists(get_parent_class($participant), 'event'));
    }
    
    /** @test */
    public function it_belongs_to_user()
    {
        $participant = new Participant();
        
        // Проверяем, существует ли метод user()
        $this->assertTrue(method_exists($participant, 'user') || 
                        method_exists(get_parent_class($participant), 'user'));
    }
    
    /** @test */
    public function it_can_be_created_with_required_attributes()
    {
        // Создаем тестовые записи в памяти с использованием массива, без обращения к базе данных
        $participant = new Participant([
            'event_id' => 1,
            'user_id' => 1
        ]);
        
        $this->assertEquals(1, $participant->event_id);
        $this->assertEquals(1, $participant->user_id);
    }
} 