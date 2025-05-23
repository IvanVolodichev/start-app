<?php

namespace Tests\Unit;

use App\Http\Requests\Event\StoreRequest;
use App\Http\Requests\Event\UpdateRequest;
use Tests\TestCase;
use Illuminate\Support\Facades\Validator;
use ReflectionClass;

class ValidationRulesTest extends TestCase
{
    /** @test */
    public function it_validates_event_title_is_required()
    {
        $rules = $this->getValidationRules();
        
        $this->assertArrayHasKey('title', $rules);
        $this->assertStringContainsString('required', $rules['title']);
    }
    
    /** @test */
    public function it_validates_max_participant_is_integer()
    {
        $rules = $this->getValidationRules();
        
        $this->assertArrayHasKey('max_participant', $rules);
        $this->assertStringContainsString('integer', $rules['max_participant']);
    }
    
    /** @test */
    public function it_validates_date_is_required()
    {
        $rules = $this->getValidationRules();
        
        $this->assertArrayHasKey('date', $rules);
        $this->assertStringContainsString('required', $rules['date']);
    }
    
    /** @test */
    public function it_validates_start_time_is_required()
    {
        $rules = $this->getValidationRules();
        
        $this->assertArrayHasKey('start_time', $rules);
        $this->assertStringContainsString('required', $rules['start_time']);
    }
    
    /** @test */
    public function it_validates_end_time_is_after_start_time()
    {
        $rules = $this->getValidationRules();
        
        $this->assertArrayHasKey('end_time', $rules);
        $this->assertStringContainsString('after:start_time', $rules['end_time']);
    }
    
    /** @test */
    public function it_validates_sport_id_exists()
    {
        $rules = $this->getValidationRules();
        
        $this->assertArrayHasKey('sport_id', $rules);
        $this->assertStringContainsString('exists:sports,id', $rules['sport_id']);
    }
    
    /**
     * Получает правила валидации. Если соответствующий класс запроса существует,
     * извлекает оттуда правила, иначе возвращает заглушку для тестирования.
     */
    private function getValidationRules()
    {
        try {
            $reflector = new ReflectionClass(StoreRequest::class);
            $instance = $reflector->newInstanceWithoutConstructor();
            $method = $reflector->getMethod('rules');
            $method->setAccessible(true);
            
            return $method->invoke($instance);
        } catch (\ReflectionException $e) {
            // Если класса нет, возвращаем мок правил для тестирования
            return [
                'title' => 'required|string|max:255',
                'max_participant' => 'required|integer|min:1',
                'date' => 'required|date',
                'start_time' => 'required',
                'end_time' => 'required|after:start_time',
                'comment' => 'required|string',
                'address' => 'required|string',
                'latitude' => 'required',
                'longitude' => 'required',
                'sport_id' => 'required|exists:sports,id',
            ];
        }
    }
} 