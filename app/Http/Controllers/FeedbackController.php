<?php

namespace App\Http\Controllers;

use App\Http\Requests\Feedback\StoreRequest;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FeedbackController extends Controller
{
    public function index(Request $request)
    {
        $feedbacksQuery = Feedback::query();
        
        if ($request->has('status') && $request->filled('status')) {
            $feedbacksQuery->where('status', $request->status);
        }
        
        $feedbacks = $feedbacksQuery->get();
        return view('feedbacks.index', compact('feedbacks'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();

        $data['user_id'] = auth()->user()->id;

        try {
            $feedback = Feedback::create($data);
        } catch (\Throwable $th) {
            Log::error('Event creation failed: ' . $th->getMessage());
            return back()->withErrors('exception', 'Произошла ошибка при создании!');
        }

        return redirect()->back()->with('success', 'Спасибо за обратную связь! Ваше обращение будет рассмотрено в ближайшее время.');
    }   

    public function show(Feedback $feedback)
    {
        return view('feedbacks.show', compact('feedback'));
    }

    public function resolve(Feedback $feedback)
    {
        if ($feedback->status === 'processing') {
            $feedback->status = 'resolved';
            $feedback->resolved_at = now();
            $feedback->save();
            return redirect()->route('feedbacks.show', $feedback)->with('success', 'Обращение помечено как решенное.');
        }
        return redirect()->route('feedbacks.show', $feedback)->with('error', 'Обращение уже было решено или не может быть изменено.');
    }
}
