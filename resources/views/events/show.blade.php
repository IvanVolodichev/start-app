@section('title', $event->title . ' — Событие')

<x-app-layout>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Заголовок и кнопки действий -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div class="flex items-center gap-3">
                <h1 class="text-4xl font-bold text-blue-600">{{ $event->title }}</h1>
                <!-- Индикатор активного события -->
                @if($event->status === 'active')
                <div class="flex items-center bg-green-600 text-white px-4 py-2 rounded-full text-sm font-bold animate-pulse">
                    <svg class="w-5 h-5 mr-1.5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                    </svg>
                    Активно сейчас
                </div>
                @endif
            </div>
            <div class="flex gap-3">
            @if(auth()->id() !== $event->user_id)
                @php
                    $participant = $event->participants->where('user_id', auth()->id())->first();
                @endphp
    
                <form method="POST" 
                    action="{{ $participant 
                        ? route('events.participants.destroy', [$event, $participant]) 
                        : route('events.participants.store', $event) }}">
                    @csrf

                    @if($participant)
                        @method('DELETE')
                    @endif
                    
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition-colors duration-200 flex items-center gap-2 {{ ($event->status === 'active' || $event->status === 'completed') && !$participant ? 'opacity-50 cursor-not-allowed' : '' }}"
                            {{ ($event->status === 'active' || $event->status === 'completed') && !$participant ? 'disabled' : '' }}
                            title="{{ $event->status === 'active' && !$participant ? 'Нельзя присоединиться к активному событию' : ($event->status === 'completed' && !$participant ? 'Нельзя присоединиться к завершенному событию' : '') }}">
                        @if($participant)
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Покинуть событие
                        @else
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                            {{ $event->status === 'active' ? 'Событие уже началось' : ($event->status === 'completed' ? 'Событие завершено' : 'Присоединиться') }}
                        @endif
                    </button>
                </form>
            @endif
                <button onclick="toggleReportModal()"
                        class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg transition-colors duration-200 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Пожаловаться
                </button>
            </div>
        </div>

        <!-- Основная информация -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
            <!-- Левая колонка -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Дата и время -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-semibold text-blue-600 mb-4">📅 Дата и время</h2>
                    <div class="grid grid-cols-2 gap-4 text-gray-700">
                        <div>
                            <p class="font-medium">Начало:</p>
                            <p>{{ $event->date->format('d.m.Y') }} в {{ $event->start_time->format('H:i') }}</p>
                        </div>
                        <div>
                            <p class="font-medium">Окончание:</p>
                            <p>{{ $event->date->format('d.m.Y') }} в {{ $event->end_time->format('H:i') }}</p>
                        </div>
                    </div>
                </div>

                <!-- Участники -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-semibold text-blue-600 mb-4">👥 Участники</h2>
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full" 
                                 style="width: {{ ($event->current_participant / $event->max_participant) * 100 }}%"></div>
                        </div>
                        <span class="text-blue-600 font-medium">{{ $event->current_participant }}/{{ $event->max_participant }}</span>
                    </div>
                </div>

                <!-- Описание -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-semibold text-blue-600 mb-4">📌 Дополнительная информация</h2>
                    <p class="text-gray-700 whitespace-pre-wrap">{{ $event->comment }}</p>
                </div>

                <div class="bg-white rounded-xl shadow-md p-6">
                    <div class="flex items-center gap-4">
                        @if($event->author->avatar)
                            <img src="{{ $event->author->avatar }}" 
                                class="w-14 h-14 rounded-full object-cover border-2 border-blue-200 shadow-sm">
                        @else
                            <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center shadow-sm">
                                <span class="text-blue-600 font-medium text-xl">
                                    {{ substr($event->author->name, 0, 1) }}
                                </span>
                            </div>
                        @endif
                        <div>
                            <a href="" 
                            class="text-lg font-semibold text-gray-800 hover:text-blue-600 transition-colors">
                                {{ $event->author->name }}
                            </a>
                            <p class="text-sm text-gray-500 mt-1">
                                Организовал {{ $event->author->events->count() }} {{ trans_choice('событие|события|событий', $event->author->events_count) }}
                            </p>
                        </div>
                    </div>
                </div>

                
                        
            </div>

            <!-- Правая колонка -->
            <div class="space-y-6">
                <!-- Вид спорта -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-semibold text-blue-600 mb-4">🏅 Вид спорта</h2>
                    <p class="text-gray-700">{{ $event->sport->name }}</p>
                </div>

                <!-- Локация -->
                <div class="bg-white rounded-xl shadow-md p-6">
                    <h2 class="text-xl font-semibold text-blue-600 mb-4">📍 Местоположение</h2>
                    <p class="text-gray-700 mb-4">{{ $event->address }}</p>
                    <div id="map" style="height: 300px;" class="rounded-lg border border-gray-200 overflow-hidden"></div>
                </div>
            </div>
        </div>

        <div class="mb-8">
            <h2 class="text-2xl font-bold text-blue-600 mb-6">📸 Галерея события</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($images as $image)
                    <a href="{{ $image }}" data-fancybox="gallery" 
                    class="group relative block overflow-hidden rounded-xl transition-transform duration-300 hover:scale-105">
                        <img src="{{ $image }}" alt="Фото события" 
                            class="w-full h-48 object-cover transform transition duration-300">
                        <div class="absolute inset-0 bg-black/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Модальное окно жалобы -->
        <div id="reportModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center p-4">
            <div class="bg-white rounded-xl p-6 max-w-md w-full">
                <h3 class="text-xl font-bold text-red-600 mb-4">Отправить жалобу</h3>
                <form method="POST" action="{{ route('events.reports.store', $event) }}">
                    @csrf
                    <input type="hidden" name="event_id" value="{{ $event->id }}">
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Причина жалобы</label>
                        <textarea name="message" rows="4" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"></textarea>
                    </div>
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="toggleReportModal()" class="px-4 py-2 text-gray-600 hover:text-gray-800">Отмена</button>
                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-6 py-2 rounded-lg transition-colors duration-200">Отправить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function toggleReportModal() {
            document.getElementById('reportModal').classList.toggle('hidden');
            document.getElementById('reportModal').classList.toggle('flex');
        }

        // Инициализация карты
        ymaps.ready(initMap);

        function initMap() {
            const map = new ymaps.Map('map', {
                center: [{{ $event->latitude }}, {{ $event->longitude }}],
                zoom: 15
            });

            const placemark = new ymaps.Placemark(
            [{{ $event->latitude }}, {{ $event->longitude }}], 
            {
                hintContent: 'Место события' // Дополнительная подсказка
            },
            {
                preset: 'islands#blueStretchyIcon', // Более подходящий пресет
                iconColor: '#1e88e5' // Дополнительная стилизация
            }
            );

        // Добавление метки на карту
            map.geoObjects.add(placemark);
        }
    </script>

<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    new Swiper('.gallerySwiper', {
        loop: true,
        autoplay: {
            delay: 5000,
        },
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        breakpoints: {
            320: {
                slidesPerView: 1,
                spaceBetween: 10
            },
            768: {
                slidesPerView: 2,
                spaceBetween: 20
            },
            1024: {
                slidesPerView: 3,
                spaceBetween: 30
            }
        }
    });
</script>



</x-app-layout>