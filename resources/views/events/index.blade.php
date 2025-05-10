@section('title', 'События')
<x-app-layout>
    <div class="container mx-auto px-4 py-8">
        <!-- Фильтры и поиск -->
        <div class="mb-8 bg-white p-6 rounded-2xl shadow-lg border border-gray-100">
        <form class="space-y-4">
                <div class="flex flex-wrap gap-4 items-end">
                    <!-- Поиск -->
                    <div class="flex-grow">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Поиск событий</label>
                        <div class="flex gap-2">
                            <input type="text" 
                                   name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Город, улица, название..."
                                   class="w-full px-4 py-3 border-2 border-blue-100 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 outline-none transition">
                            <button type="submit" class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:opacity-90 transition-opacity shadow-md">
                                Найти
                            </button>
                        </div>
                    </div>

                    <!-- Фильтр по спорту -->
                    <div class="min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Вид спорта</label>
                        <select 
                            name="sport" 
                            class="w-full px-4 py-3 border-2 border-blue-100 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 outline-none transition"
                            onchange="this.form.submit()"
                        >
                            <option value="all">Все виды</option>
                            @foreach($sports as $sport)
                                <option value="{{ $sport->id }}" {{ request('sport') == $sport->id ? 'selected' : '' }}>
                                    {{ $sport->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Фильтр по участникам -->
                    <div class="min-w-[200px]">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Участники</label>
                        <select 
                            name="participants" 
                            class="w-full px-4 py-3 border-2 border-blue-100 rounded-xl focus:ring-4 focus:ring-blue-200 focus:border-blue-500 outline-none transition"
                            onchange="this.form.submit()"
                        >
                            <option value="all" {{ request('participants') == 'all' ? 'selected' : '' }}>Любое количество</option>
                            <option value="up_to_5" {{ request('participants') == 'up_to_5' ? 'selected' : '' }}>До 5 участников</option>
                            <option value="5_to_10" {{ request('participants') == '5_to_10' ? 'selected' : '' }}>5-10 участников</option>
                            <option value="over_10" {{ request('participants') == 'over_10' ? 'selected' : '' }}>10+ участников</option>
                        </select>
                    </div>

                    <!-- Кнопка сброса -->
                    <div class="flex-shrink-0">
                        <a 
                            href="{{ route('events.index') }}" 
                            class="flex items-center px-6 py-3 bg-gradient-to-r from-gray-100 to-gray-200 text-gray-700 rounded-xl hover:opacity-90 transition-opacity shadow-md border border-gray-300"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Сбросить
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Сетка событий -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($events as $event)
                <a href="{{ route('events.show', $event) }}" class="group">
                    <div class="relative bg-white p-6 rounded-2xl shadow-md hover:shadow-xl transition-shadow border-2 border-blue-50 overflow-hidden">
                        
                            <div class="h-48 mb-4 rounded-lg overflow-hidden">
                                <img 
                                    src="{{ $event->titleImage() }}" 
                                    alt="{{ $event->title }}"
                                    class="w-full h-full object-cover transform group-hover:scale-105 transition-transform">
                            </div>

                        <!-- Заголовок -->
                        <h3 class="text-xl font-bold text-gray-800 mb-4 group-hover:text-blue-600 transition-colors">
                            {{ $event->title }}
                        </h3>

                        <!-- Детали -->
                        <div class="space-y-3 text-gray-600">
                            <!-- Дата и время -->
                            <div class="flex items-center bg-blue-50 p-3 rounded-lg">
                                <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="font-medium">
                                    {{ $event->date->translatedFormat('j F Y') }} <!-- Изменили формат -->
                                </span>
                            </div>

                            <!-- Участники -->
                            <div class="flex items-center bg-blue-50 p-3 rounded-lg">
                                <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                                <span class="font-medium">{{ $event->current_participant }}/{{ $event->max_participant }} участников</span>
                            </div>

                            <!-- Адрес -->
                            <div class="flex items-center bg-blue-50 p-3 rounded-lg">
                                <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="font-medium">{{ Str::limit($event->address, 30) }}</span>
                            </div>
                        </div>

                        <!-- Водяной знак -->
                        <div class="absolute top-2 right-2 bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium">
                            {{ $event->sport->name }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Пагинация -->
        <div class="mt-8">
            {{ $events->links() }}
        </div>
    </div>
</x-app-layout>