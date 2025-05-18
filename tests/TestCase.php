<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;

abstract class TestCase extends BaseTestCase
{
    use RefreshDatabase;
    
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        parent::setUp();
        
        // Отключаем обработку исключений для более ясных ошибок
        $this->withoutExceptionHandling();
        
        // For SQLite, we need to disable foreign key checks when refreshing the database
        if (DB::connection()->getDriverName() === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF');
        }
    }
    
    /**
     * Reset the database after each test.
     */
    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
