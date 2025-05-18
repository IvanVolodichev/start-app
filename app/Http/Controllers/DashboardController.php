<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Event;
use App\Models\Report;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke()
    {
        // Статистика пользователей
        $totalUsers = User::count();

        // Статистика событий
        $activeEvents = Event::where('status', 'active')->count();
        $completedEvents = Event::where('status', 'completed')->count();
        $totalEvents = Event::count();

        // Статистика обращений
        $totalFeedbacks = Feedback::count();
        $unprocessedFeedbacks = Feedback::where('status', 'processing')->count();

        // Статистика жалоб
        $totalReports = Report::count();
        $unprocessedReports = Report::where('status', 'processing')->count();

        // Последние действия (объединяем последние действия из разных моделей)
        $recentActivities = collect()
            ->concat(
                Event::latest()
                    ->take(5)
                    ->get()
                    ->map(function ($event) {
                        return (object)[
                            'type' => 'Событие',
                            'description' => "Создано событие: {$event->title}",
                            'created_at' => $event->created_at,
                            'status' => $event->status
                        ];
                    })
            )
            ->concat(
                Report::latest()
                    ->take(5)
                    ->get()
                    ->map(function ($report) {
                        return (object)[
                            'type' => 'Жалоба',
                            'description' => "Получена жалоба от пользователя #{$report->user_id}",
                            'created_at' => $report->created_at,
                            'status' => $report->status
                        ];
                    })
            )
            ->concat(
                Feedback::latest()
                    ->take(5)
                    ->get()
                    ->map(function ($feedback) {
                        return (object)[
                            'type' => 'Обращение',
                            'description' => "Получено обращение от пользователя #{$feedback->user_id}",
                            'created_at' => $feedback->created_at,
                            'status' => $feedback->status
                        ];
                    })
            )
            ->sortByDesc('created_at')
            ->take(10);

        return view('admin.dashboard', compact(
            'totalUsers',
            'activeEvents',
            'completedEvents',
            'totalEvents',
            'totalFeedbacks',
            'unprocessedFeedbacks',
            'totalReports',
            'unprocessedReports',
            'recentActivities'
        ));
    }
}
