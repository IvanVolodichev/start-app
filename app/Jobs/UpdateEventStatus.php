<?php

namespace App\Jobs;

use App\Models\Event;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class UpdateEventStatus implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $now = Carbon::now()->timezone('Europe/Moscow');
        Log::info('Running event status update job at: ' . $now->toDateTimeString());

        // Update planned events to active when start time is reached
        $plannedEvents = Event::where('status', 'planned')->get();
        Log::info('Total planned events: ' . $plannedEvents->count());

        foreach ($plannedEvents as $event) {
            try {
                // Создаем дату события
                $eventDate = Carbon::parse($event->date)->timezone('Europe/Moscow');
                // Получаем время начала события
                $startTime = Carbon::parse($event->start_time);
                // Комбинируем дату и время
                $eventDateTime = $eventDate->setTimeFrom($startTime);

                Log::info("Checking event ID: {$event->id}, Title: {$event->title}");
                Log::info("Event start time: " . $eventDateTime->toDateTimeString());
                Log::info("Current time: " . $now->toDateTimeString());

                // Проверяем, что текущее время больше или равно времени начала события
                if ($now->timestamp >= $eventDateTime->timestamp) {
                    Log::info("Activating event ID: {$event->id}, Title: {$event->title}");
                    $event->update(['status' => 'active']);
                } else {
                    Log::info("Event ID: {$event->id} is not ready to activate yet. Time difference: " . 
                        $now->diffInSeconds($eventDateTime) . " seconds");
                }
            } catch (\Exception $e) {
                Log::error("Error processing event ID: {$event->id}, Error: " . $e->getMessage());
                Log::error("Event data - Date: {$event->date}, Start time: {$event->start_time}");
            }
        }

        // Update active events to completed when end time is reached
        $activeEvents = Event::where('status', 'active')->get();
        Log::info('Total active events: ' . $activeEvents->count());

        foreach ($activeEvents as $event) {
            try {
                // Создаем дату события
                $eventDate = Carbon::parse($event->date)->timezone('Europe/Moscow');
                // Получаем время окончания события
                $endTime = Carbon::parse($event->end_time);
                // Комбинируем дату и время
                $eventEndDateTime = $eventDate->setTimeFrom($endTime);

                Log::info("Checking event ID: {$event->id}, Title: {$event->title}");
                Log::info("Event end time: " . $eventEndDateTime->toDateTimeString());
                Log::info("Current time: " . $now->toDateTimeString());

                // Проверяем, что текущее время больше или равно времени окончания события
                if ($now->timestamp >= $eventEndDateTime->timestamp) {
                    Log::info("Completing event ID: {$event->id}, Title: {$event->title}");
                    $event->update(['status' => 'completed']);
                } else {
                    Log::info("Event ID: {$event->id} is not ready to complete yet. Time difference: " . 
                        $now->diffInSeconds($eventEndDateTime) . " seconds");
                }
            } catch (\Exception $e) {
                Log::error("Error processing event ID: {$event->id}, Error: " . $e->getMessage());
                Log::error("Event data - Date: {$event->date}, End time: {$event->end_time}");
            }
        }
    }
} 