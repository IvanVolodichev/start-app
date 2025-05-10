<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\UpdateEventStatuses;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        UpdateEventStatuses::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Add explicit time-based scheduling
        $schedule->command('events:update-status')
            ->everyMinute()
            ->appendOutputTo(storage_path('logs/scheduler.log'))
            ->before(function () {
                Log::info('About to run events:update-status command');
            })
            ->after(function () {
                Log::info('Finished running events:update-status command');
            });
        
        // Test log entry
        $schedule->call(function () {
            Log::info('Cron is working at: ' . now()->toDateTimeString());
        })->everyMinute()
          ->appendOutputTo(storage_path('logs/scheduler.log'));
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
} 