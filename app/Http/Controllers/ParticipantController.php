<?php

namespace App\Http\Controllers;

use App\Models\Participant;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ParticipantController extends Controller
{
    public function store(Event $event, Request $request)
    {
        try {

            DB::beginTransaction();

            $participant = Participant::create([
                'event_id' => $event->id,
                'user_id' => auth()->user()->id,
            ]);

            $event->current_participant += 1;

            $event->save();

            DB::commit();

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return back()->withErrors(['exception' => 'Произошла !']);
        }

        return redirect()->route('events.show', $event)->with('success', 'Вы присоединились к событию!');
    }

    public function destroy(Event $event, Participant $participant)
    {
        try {
            DB::beginTransaction();

            if ($participant->user_id !== auth()->id()) {
                abort(403);
            }

            $participant->delete();

            $event->current_participant = max(0, $event->current_participant - 1);
            $event->save();

            DB::commit();

        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return back()->withErrors(['exception' => 'Произошла ошибка!']);
        }

        return redirect()->route('events.show', $event)->with('success', 'Вы покинули событие!');
    }
}
