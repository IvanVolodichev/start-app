<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use App\Models\Report;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Командные виды спорта'],
            ['name' => 'Ракеточные виды'],
            ['name' => 'Единоборства'],
            ['name' => 'Водные виды'],
            ['name' => 'Зимние виды'],
            ['name' => 'Экстремальные виды'],
            ['name' => 'Фитнес'],
            ['name' => 'Танцевальный спорт'],
            ['name' => 'Гимнастика'],
            ['name' => 'Легкая атлетика'],
            ['name' => 'Тяжелая атлетика'],
            ['name' => 'Парусный спорт'],
            ['name' => 'Конный спорт'],
            ['name' => 'Стрелковые виды'],
            ['name' => 'Горные виды'],
            ['name' => 'Спортивное ориентирование'],
        ];

        $sports = [
            // Командные виды спорта (1)
            [
                'name' => 'Волейбол',
                'description' => 'Игра 6 на 6 с мячом через сетку',
                'category_id' => 1
            ],
            [
                'name' => 'Футбол',
                'description' => 'Игра 11 на 11 с мячом на прямоугольном поле',
                'category_id' => 1
            ],
            [
                'name' => 'Баскетбол',
                'description' => 'Игра с мячом и кольцами на площадке 28×15 м',
                'category_id' => 1
            ],
            [
                'name' => 'Гандбол',
                'description' => 'Игра 7 на 7 с мячом, сочетающая элементы футбола и баскетбола',
                'category_id' => 1
            ],
            [
                'name' => 'Регби',
                'description' => 'Контактный спорт с овальным мячом и захватами',
                'category_id' => 1
            ],
        
            // Ракеточные виды (2)
            [
                'name' => 'Теннис',
                'description' => 'Игра с ракетками на корте с сеткой',
                'category_id' => 2
            ],
            [
                'name' => 'Сквош',
                'description' => 'Игра в закрытом корте со специальными отметками',
                'category_id' => 2
            ],
            [
                'name' => 'Бадминтон',
                'description' => 'Игра с воланом и сеткой на прямоугольной площадке',
                'category_id' => 2
            ],
            [
                'name' => 'Настольный теннис',
                'description' => 'Динамичная игра на столе с маленьким мячом',
                'category_id' => 2
            ],
        
            // Единоборства (3)
            [
                'name' => 'Дзюдо',
                'description' => 'Японское боевое искусство с бросками и захватами',
                'category_id' => 3
            ],
            [
                'name' => 'Карате',
                'description' => 'Удары руками и ногами с использованием поясов',
                'category_id' => 3
            ],
            [
                'name' => 'Бокс',
                'description' => 'Кулачный бой в перчатках по строгим правилам',
                'category_id' => 3
            ],
            [
                'name' => 'Тхэквондо',
                'description' => 'Корейское боевое искусство с акцентом на удары ногами',
                'category_id' => 3
            ],
        
            // Водные виды (4)
            [
                'name' => 'Плавание',
                'description' => 'Соревнования в бассейне разными стилями',
                'category_id' => 4
            ],
            [
                'name' => 'Синхронное плавание',
                'description' => 'Комбинации движений в воде под музыку',
                'category_id' => 4
            ],
            [
                'name' => 'Прыжки в воду',
                'description' => 'Акробатические элементы с трамплина или вышки',
                'category_id' => 4
            ],
            [
                'name' => 'Гребля на байдарках',
                'description' => 'Скоростные гонки на узких лодках',
                'category_id' => 4
            ],
        
            // Зимние виды (5)
            [
                'name' => 'Биатлон',
                'description' => 'Лыжная гонка со стрельбой из винтовки',
                'category_id' => 5
            ],
            [
                'name' => 'Кёрлинг',
                'description' => 'Скольжение камней по льду с щётками',
                'category_id' => 5
            ],
            [
                'name' => 'Хоккей с шайбой',
                'description' => 'Игра на льду с клюшками и шайбой',
                'category_id' => 5
            ],
            [
                'name' => 'Сноуборд',
                'description' => 'Спуск по склонам на одной широкой доске',
                'category_id' => 5
            ],
        
            // Экстремальные виды (6)
            [
                'name' => 'Скейтбординг',
                'description' => 'Трюки на доске с колёсами',
                'category_id' => 6
            ],
            [
                'name' => 'Скалолазание',
                'description' => 'Преодоление естественных/искусственных стен',
                'category_id' => 6
            ],
            [
                'name' => 'BMX',
                'description' => 'Трюковая езда на специальных велосипедах',
                'category_id' => 6
            ],
            [
                'name' => 'Паркур',
                'description' => 'Преодоление препятствий с помощью прыжков и акробатики',
                'category_id' => 6
            ],
        
            // Фитнес (7)
            [
                'name' => 'Кроссфит',
                'description' => 'Высокоинтенсивные функциональные тренировки',
                'category_id' => 7
            ],
            [
                'name' => 'Пилатес',
                'description' => 'Система упражнений для развития гибкости',
                'category_id' => 7
            ],
            [
                'name' => 'Йога',
                'description' => 'Практика для гармонии тела и сознания',
                'category_id' => 7
            ],
            [
                'name' => 'Аэробика',
                'description' => 'Ритмичные упражнения под музыку для выносливости',
                'category_id' => 7
            ],
        
            // Танцевальный спорт (8)
            [
                'name' => 'Бальные танцы',
                'description' => 'Стандартные и латиноамериканские программы',
                'category_id' => 8
            ],
            [
                'name' => 'Брейк-данс',
                'description' => 'Уличный танец с акробатическими элементами',
                'category_id' => 8
            ],
            [
                'name' => 'Хип-хоп',
                'description' => 'Энергичный уличный танцевальный стиль',
                'category_id' => 8
            ],
            [
                'name' => 'Современные танцы',
                'description' => 'Экспериментальные хореографические направления',
                'category_id' => 8
            ],
        
            // Гимнастика (9)
            [
                'name' => 'Художественная гимнастика',
                'description' => 'Упражнения с лентами/обручем под музыку',
                'category_id' => 9
            ],
            [
                'name' => 'Прыжки на батуте',
                'description' => 'Акробатические элементы в полёте',
                'category_id' => 9
            ],
            [
                'name' => 'Спортивная гимнастика',
                'description' => 'Упражнения на брусьях, кольцах и бревне',
                'category_id' => 9
            ],
            [
                'name' => 'Акробатика',
                'description' => 'Комбинации прыжков, переворотов и балансирования',
                'category_id' => 9
            ],
        
            // Легкая атлетика (10)
            [
                'name' => 'Спринт',
                'description' => 'Бег на короткие дистанции (100-400 м)',
                'category_id' => 10
            ],
            [
                'name' => 'Метание копья',
                'description' => 'Соревнования на дальность броска',
                'category_id' => 10
            ],
            [
                'name' => 'Марафон',
                'description' => 'Бег на длинную дистанцию (42,195 км)',
                'category_id' => 10
            ],
            [
                'name' => 'Прыжки в длину',
                'description' => 'Соревнования на максимальную дальность прыжка',
                'category_id' => 10
            ],
        
            // Тяжелая атлетика (11)
            [
                'name' => 'Рывок',
                'description' => 'Поднятие штанги над головой одним движением',
                'category_id' => 11
            ],
            [
                'name' => 'Пауэрлифтинг',
                'description' => 'Троеборье: присед, жим, становая тяга',
                'category_id' => 11
            ],
            [
                'name' => 'Толчок',
                'description' => 'Поднятие штанги в два приёма: на грудь и над головой',
                'category_id' => 11
            ],
            [
                'name' => 'Гиревой спорт',
                'description' => 'Упражнения с гирями на силу и выносливость',
                'category_id' => 11
            ],
        
            // Парусный спорт (12)
            [
                'name' => 'Виндсерфинг',
                'description' => 'Скоростное движение на доске с парусом',
                'category_id' => 12
            ],
            [
                'name' => 'Кайтсерфинг',
                'description' => 'Скольжение по воде с воздушным змеем',
                'category_id' => 12
            ],
            [
                'name' => 'Яхтинг',
                'description' => 'Гонки на парусных яхтах разного класса',
                'category_id' => 12
            ],
            [
                'name' => 'Парусные гонки',
                'description' => 'Соревнования на скорость и маневренность',
                'category_id' => 12
            ],
        
            // Конный спорт (13)
            [
                'name' => 'Конкур',
                'description' => 'Преодоление препятствий верхом на лошади',
                'category_id' => 13
            ],
            [
                'name' => 'Выездка',
                'description' => 'Высшая школа верховой езды',
                'category_id' => 13
            ],
            [
                'name' => 'Троеборье',
                'description' => 'Комбинация манежной езды, кросса и конкура',
                'category_id' => 13
            ],
            [
                'name' => 'Вольтижировка',
                'description' => 'Выполнение гимнастических упражнений на лошади',
                'category_id' => 13
            ],
        
            // Стрелковые виды (14)
            [
                'name' => 'Стендовая стрельба',
                'description' => 'Стрельба по летящим тарелочкам',
                'category_id' => 14
            ],
            [
                'name' => 'Стрельба из лука',
                'description' => 'Попадание стрелами в мишени',
                'category_id' => 14
            ],
            [
                'name' => 'Стрельба из пневматической винтовки',
                'description' => 'Соревнования на точность на дистанции 10 метров',
                'category_id' => 14
            ],
            [
                'name' => 'Скоростная стрельба из пистолета',
                'description' => 'Стрельба по мишеням на время',
                'category_id' => 14
            ],
        
            // Горные виды (15)
            [
                'name' => 'Альпинизм',
                'description' => 'Восхождения на горные вершины',
                'category_id' => 15
            ],
            [
                'name' => 'Горные лыжи',
                'description' => 'Спуск по подготовленным трассам',
                'category_id' => 15
            ],
            [
                'name' => 'Фрирайд',
                'description' => 'Спуск на лыжах/сноуборде по нетронутым склонам',
                'category_id' => 15
            ],
            [
                'name' => 'Ски-альпинизм',
                'description' => 'Восхождение на гору и спуск на лыжах',
                'category_id' => 15
            ],
        
            // Спортивное ориентирование (16)
            [
                'name' => 'Лыжное ориентирование',
                'description' => 'Навигация по карте на лыжах',
                'category_id' => 16
            ],
            [
                'name' => 'Рогейн',
                'description' => 'Длительное командное ориентирование',
                'category_id' => 16
            ],
            [
                'name' => 'Велоориентирование',
                'description' => 'Навигация по маршруту на горном велосипеде',
                'category_id' => 16
            ],
            [
                'name' => 'Ночное ориентирование',
                'description' => 'Соревнования в условиях ограниченной видимости',
                'category_id' => 16
            ]
        ];

        DB::table('categories')->insert($categories);
        DB::table('sports')->insert($sports);

        $this->call([
            UserSeeder::class,
            EventSeeder::class,
            ParticipantSeeder::class,
            ReportSeeder::class,
            FeedbackSeeder::class,
        ]);

        // Обновляем счетчики участников для каждого события
        $this->command->info('Updating event participant counts...');
        Event::all()->each(function (Event $event) {
            $count = $event->participants()->count();
            $event->update(['current_participant' => $count]);
        });
        $this->command->info('Event participant counts updated.');

        // Блокируем события, если есть принятые жалобы
        $this->command->info('Blocking events based on accepted reports...');
        Report::where('status', 'accepted')->with('event')->get()->each(function ($report) {
            if ($report->event) {
                // Проверяем, что событие еще не заблокировано или не в другом конечном статусе
                if (!in_array($report->event->status, ['blocked', 'deleted', 'completed'])) {
                    $report->event->status = 'blocked';
                    $report->event->save();
                    $this->command->line("Event ID: {$report->event->id} has been blocked due to accepted report ID: {$report->id}");
                }
            } else {
                 $this->command->warn("Report ID: {$report->id} (status: accepted) has no associated event or event was deleted.");
            }
        });
        $this->command->info('Events blocking process completed.');
    }
}   
