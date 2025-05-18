<?php

namespace Database\Factories;

use App\Models\Report;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReportFactory extends Factory
{
    protected $model = Report::class;

    public function definition()
    {
        $status = $this->faker->randomElement(['processing', 'accepted', 'rejected']);
        $resolvedAt = ($status === 'processing') ? null : $this->faker->dateTimeThisMonth();

        return [
            'message' => $this->faker->paragraph,
            'event_id' => Event::factory(),
            'user_id' => User::factory(),
            'status' => $status,
            'resolved_at' => $resolvedAt,
        ];
    }
} 