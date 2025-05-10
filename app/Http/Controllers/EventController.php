<?php

namespace App\Http\Controllers;

use App\Http\Requests\Event\StoreRequest;
use App\Http\Requests\Event\UpdateRequest;
use App\Models\Event;
use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class EventController extends Controller
{
    public function index(Request $request)
    {
        \Carbon\Carbon::setLocale('ru');

        $query = Event::query()
            ->where('status', 'planned')
            ->with('sport')
            ->latest();

        // Поиск по названию и адресу
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title',   'like', "%{$search}%")
                ->orWhere('address', 'like', "%{$search}%");
            });
        }

        // Фильтр по виду спорта
        if ($sport = $request->input('sport')) {
            if ($sport !== 'all') {
                $query->where('sport_id', $sport);
            }
        }

        // Фильтр по количеству участников
        if ($part = $request->input('participants')) {
            if ($part !== 'all') {
                switch ($part) {
                    case 'up_to_5':
                        $query->where('max_participant', '<=', 5);
                        break;
                    case '5_to_10':
                        $query->whereBetween('max_participant', [5, 10]);
                        break;
                    case 'over_10':
                        $query->where('max_participant', '>', 10);
                        break;
                }
            }
        }

        $events = $query
            ->paginate(9)
            ->appends($request->except('page'));

        $sports = Sport::orderBy('name')->get();

        return view('events.index', compact('events', 'sports'));
    }

    public  function create()
    {
        $sports = Sport::orderBy('name')->get();
        return view('events.create', compact('sports'));
    }

    public  function store(StoreRequest $request)
    {
        $data = $request->validated();

        $cloudFolder = Str::uuid();

        $data['user_id'] = auth()->user()->id;
        $data['cloud_folder'] = $cloudFolder;

        $storage = Storage::disk('reg');

        try {
            DB::beginTransaction();

            $event = Event::create($data);

            foreach ($request->file('images') as $image) {
                $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
                $image->storeAs($event->cloud_folder, $filename, 'reg');
            }

            DB::commit();

        } catch (\Throwable $th) {
            DB::rollBack();
            $storage->deleteDirectory($cloudFolder);
            Log::error('Event creation failed: ' . $th->getMessage());
            return back()->withErrors(['exception' => 'Произошла ошибка при создании!']);
        }

        return redirect()->route('events.show', $event)->with('success', 'Событие успешно создано!');
    }

    public  function show(Event $event)
    {
        $storage = Storage::disk('reg');

        $files = $storage->allFiles($event->cloud_folder);
        $images = [];

        foreach ($files as $filePath) {
            $images[] = $storage->url($filePath);
        }

        return view('events.show', compact('event', 'images'));
    }

    public  function edit(Event $event)
    {
        $sports = Sport::orderBy('name')->get();

        $storage = Storage::disk('reg');

        $files = $storage->allFiles($event->cloud_folder);
        $images = [];

        foreach ($files as $filePath) {
            $images[] = $storage->url($filePath);
        }
        return view('events.edit', compact('event', 'sports', 'images'));
    }

    public  function update(Event $event, UpdateRequest $request)
    {
        $data = $request->validated();
        $storage = Storage::disk('reg');

        try {
            DB::beginTransaction();

            // Обновляем основные данные события
            $event->update($data);

            // Обрабатываем удаление изображений
            if ($request->filled('deleted_images')) {
                foreach ($request->deleted_images as $imageUrl) {
                    // Получаем путь к файлу из URL
                    $path = parse_url($imageUrl, PHP_URL_PATH);
                    if ($path) {
                        // Удаляем начальный слеш и получаем относительный путь
                        $relativePath = ltrim($path, '/');
                        if ($storage->exists($relativePath)) {
                            $storage->delete($relativePath);
                        }
                    }
                }
            }

            // Обрабатываем загрузку новых изображений
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $filename = Str::uuid() . '.' . $image->getClientOriginalExtension();
                    $image->storeAs($event->cloud_folder, $filename, 'reg');
                }
            }

            DB::commit();
            return redirect()->route('events.show', $event)->with('success', 'Событие успешно обновлено!');

        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Event update failed: ' . $th->getMessage());
            return redirect()->back()->withErrors(['exception' => 'Произошла ошибка при обновлении события!']);
        }
    }

    public  function destroy(Event $event)
    {
        $storage = Storage::disk('reg');
        $storage->deleteDirectory($event->cloud_folder);

        try {
            $event->delete();
            return redirect()->route('events.my')->with('success', 'Событие успешно удалено!');
        } catch (\Throwable $th) {
            Log::error('Event deletion failed: ' . $th->getMessage());
            return redirect()->back()->withErrors(['exception' => 'Произошла ошибка при удалении события!']);
        }
    }

    public function myEvents()
    {
        $events = auth()->user()->events()
            ->with('sport')
            ->latest()
            ->paginate(9);

        return view('events.my', compact('events'));
    }

    public function participatedEvents()
    {
        $events = Event::whereHas('participants', function($query) {
                $query->where('user_id', auth()->id())->where('status', 'planned');
            })
            ->with('sport')
            ->latest()
            ->paginate(9);

        return view('events.participated', compact('events'));
    }
    
}
