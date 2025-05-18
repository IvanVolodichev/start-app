<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Log;
use App\Models\Report;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Report\ActionRequest;


class ReportController extends Controller
{
    public function index(Request $request)
    {
        $query = Report::query();

        if ($request->has('status') && $request->filled('status')) {
            $query->where('status', $request->status);
        }

        $reports = $query->get();
        return view('reports.index', compact('reports'));
    }

    public function reject(ActionRequest $request)
    {
        DB::transaction(function () use ($request) {
            $report = Report::find($request->report_id);
            $report->status = 'rejected';
            $report->resolved_at = now();
            $report->save();
        });
        return redirect()->back()->with('success', 'Жалоба отклонена.');
    }

    public function block(ActionRequest $request)
    {
        DB::transaction(function () use ($request) {
            $report = Report::find($request->report_id);
            $report->status = 'accepted';
            $report->resolved_at = now();
            $report->event->status = 'blocked';
            $report->event->save();
            $report->save();
        });
        return redirect()->back()->with('success', 'Жалоба принята.');
    }

    public function store(Request $request, Event $event)
    {

        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        try {
            $event->reports()->create([
                'message' => $request->message,
                'user_id' => auth()->id(),
            ]);
    
            return redirect()->back()->with('success', 'Ваша жалоба будет рассмотрена в ближайшее время.');
        } catch (\Exception $e) {
            Log::error('ReportController@store: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Ошибка при отправке жалобы.');
        }
    }
}
