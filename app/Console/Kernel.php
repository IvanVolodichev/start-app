<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\UpdateEventStatuses;
use App\Console\Commands\TestCommand;
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
        TestCommand::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Add explicit time-based scheduling
        $schedule->command('events:update-status')
            ->everyMinute()
            ->appendOutputTo(storage_path('logs/laravel.log'))
            ->before(function () {
                Log::info('About to run events:update-status command');
            })
            ->after(function () {
                Log::info('Finished running events:update-status command');
            });


        $schedule->command('app:test-command')
            ->everyMinute();
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