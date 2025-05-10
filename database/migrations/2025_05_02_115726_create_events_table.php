<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('max_participant');
            $table->unsignedInteger('current_participant')->default(0);
            $table->date('date');
            $table->time('start_time');
            $table->time('end_time');
            $table->text('comment');
            $table->string('title');
            $table->string('cloud_folder')->unique();
            $table->text('address');
            $table->text('latitude');
            $table->text('longitude');
            $table->enum('status', ['planned', 'active', 'frozen', 'deleted', 'completed'])->default('planned');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');;
            $table->foreignId('sport_id')->constrained()->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
