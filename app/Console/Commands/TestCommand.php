<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Event;
class TestCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:test-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command Test';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $events = Event::first();

        $this->info($events);
    }
}
