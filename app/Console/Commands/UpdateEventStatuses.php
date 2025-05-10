<?php

namespace App\Console\Commands;

use App\Jobs\UpdateEventStatus;
use Illuminate\Console\Command;

class UpdateEventStatuses extends Command
{
    protected $signature = 'events:update-status';
    protected $description = 'Update event statuses based on their dates and times';

    public function handle()
    {
        UpdateEventStatus::dispatch();
        $this->info('Event status update job has been dispatched.');
    }
} 