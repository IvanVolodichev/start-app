<?php

namespace Database\Factories;

use App\Models\Feedback;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class FeedbackFactory extends Factory
{
    protected $model = Feedback::class;

    public function definition()
    {
        $status = $this->faker->randomElement(['processing', 'resolved']);
        $resolvedAt = ($status === 'processing') ? null : $this->faker->dateTimeThisMonth();

        return [
            'message' => $this->faker->paragraph,
            'user_id' => User::factory(),
            'status' => $status,
            'resolved_at' => $resolvedAt,
        ];
    }
} 