<?php

namespace App\Http\Controllers;

use App\Http\Requests\Feedback\StoreRequest;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class FeedbackController extends Controller
{
    public function index()
    {

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

        return redirect()->route('feedbacks.create')->with('success', 'Спасибо за обратную связь! Ваше обращение будет рассмотрено в ближайшее время.');
    }   

    public function show()
    {

    }

    public function delete()
    {

    }


}
