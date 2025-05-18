<?php

namespace Database\Seeders;

use App\Models\Participant;
use App\Models\Event;
use App\Models\User;
use Illuminate\Database\Seeder;

class ParticipantSeeder extends Seeder
{
    public function run()
    {
        $events = Event::whereNotIn('status', ['blocked', 'deleted', 'completed'])->get();
        $users = User::all();

        if ($events->isEmpty()) {
            $this->command->info('ParticipantSeeder: No suitable events found to add participants. Skipping.');
            return;
        }

        if ($users->isEmpty()) {
            $this->command->info('ParticipantSeeder: No users found to be participants. Skipping.');
            // Опционально: создать пользователей, если их нет
            // User::factory()->count(10)->create();
            // $users = User::all();
            // if($users->isEmpty()) return;
            return;
        }

        $participantsToCreate = 300; // Количество участников для создания, как было в первоначальном сидере

        for ($i = 0; $i < $participantsToCreate; $i++) {
            if ($events->isEmpty()) break; // Если все подходящие события закончились
            
            $event = $events->random();

            // Проверяем, может ли событие принять еще участников
            // На данном этапе current_participant еще не обновлен, поэтому полагаемся на max_participant
            // и количество уже созданных участников в этой сессии сидера для данного события (если бы мы это отслеживали здесь).
            // Более простой подход для сидера - создать, а DatabaseSeeder потом обновит счетчик.
            // Однако, чтобы избежать явного превышения max_participant записями в таблице:
            if ($event->participants()->count() >= $event->max_participant) {
                // Если событие уже заполнено (согласно текущим записям), пропускаем его в этой итерации
                // и удаляем из списка доступных, чтобы не выбирать его снова.
                $events = $events->reject(function ($e) use ($event) {
                    return $e->id === $event->id;
                });
                $i--; // Повторяем попытку для другого события
                continue;
            }
            
            $user = $users->random();

            // Избегаем дублирования участника (тот же пользователь для того же события)
            $isAlreadyParticipant = Participant::where('event_id', $event->id)
                                              ->where('user_id', $user->id)
                                              ->exists();

            if (!$isAlreadyParticipant) {
                Participant::factory()->create([
                    'event_id' => $event->id,
                    'user_id' => $user->id,
                ]);
            } else {
                // Если пытаемся создать дубликат, уменьшаем счетчик, чтобы попытаться создать нужное количество
                // Это может привести к большему количеству итераций, если пользователи/события ограничены
                 $i--; // Повторяем попытку
            }
        }
        $this->command->info('ParticipantSeeder: Participants seeding attempt completed.');
    }
} 