<?php

namespace Tests\Unit;

use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class EventMethodsTest extends TestCase
{
    /** @test */
    public function title_image_returns_default_when_no_images()
    {
        // Создаем мок для хранилища
        Storage::fake('reg');
        
        $event = new Event([
            'cloud_folder' => 'events/test-folder'
        ]);
        
        $this->assertEquals(asset('./default.png'), $event->titleImage());
    }
    
    /** @test */
    public function title_image_returns_first_image_when_available()
    {
        // Создаем мок для хранилища
        Storage::fake('reg');
        
        // Добавляем файл в хранилище
        $imagePath = 'events/test-folder/image.jpg';
        Storage::disk('reg')->put($imagePath, 'test content');
        
        $event = new Event([
            'cloud_folder' => 'events/test-folder'
        ]);
        
        // Проверяем, что возвращается URL первого изображения
        $this->assertEquals(
            Storage::disk('reg')->url('events/test-folder/image.jpg'),
            $event->titleImage()
        );
    }
    
    /** @test */
    public function event_status_can_be_planned()
    {
        $event = new Event(['status' => 'planned']);
        $this->assertEquals('planned', $event->status);
    }
    
    /** @test */
    public function event_status_can_be_active()
    {
        $event = new Event(['status' => 'active']);
        $this->assertEquals('active', $event->status);
    }
    
    /** @test */
    public function event_status_can_be_completed()
    {
        $event = new Event(['status' => 'completed']);
        $this->assertEquals('completed', $event->status);
    }
    
    /** @test */
    public function event_status_can_be_blocked()
    {
        $event = new Event(['status' => 'blocked']);
        $this->assertEquals('blocked', $event->status);
    }
    
    /** @test */
    public function event_status_can_be_deleted()
    {
        $event = new Event(['status' => 'deleted']);
        $this->assertEquals('deleted', $event->status);
    }
} 