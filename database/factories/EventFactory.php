<?php

namespace Database\Factories;

use App\Models\Event;
use App\Models\User;
use App\Models\Sport;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EventFactory extends Factory
{
    protected $model = Event::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'comment' => $this->faker->paragraph,
            'date' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d'),
            'start_time' => $startTime = $this->faker->time('H:i:s'),
            'end_time' => function () use ($startTime) {
                $start = \DateTime::createFromFormat('H:i:s', $startTime);
                $maxEndTime = \DateTime::createFromFormat('H:i:s', '23:59:59');
                
                // If there's not enough time left in the day, make end_time 1-3 hours after start_time,
                // but cap at 23:59:59
                $endDateTime = (clone $start)->modify('+' . rand(1, 3) . ' hours');
                if ($endDateTime > $maxEndTime) {
                    $endDateTime = $maxEndTime;
                }
                
                return $endDateTime->format('H:i:s');
            },
            'address' => $this->faker->address,
            'max_participant' => $this->faker->numberBetween(10, 100),
            'cloud_folder' => 'events/' . Str::uuid()->toString(),
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
            'status' => 'planned',
            'user_id' => User::factory(),
            'sport_id' => Sport::factory(),
        ];
    }
} 