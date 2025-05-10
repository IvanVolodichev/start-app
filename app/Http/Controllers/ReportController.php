<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
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
