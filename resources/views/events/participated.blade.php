@section('title', 'Участие в событиях')
<x-app-layout>
    <div class="container mx-auto px-4 py-8">
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
                            {{ Str::limit($event->title, 30) }}
                        </h3>

                        <!-- Детали -->
                        <div class="space-y-3 text-gray-600">
                            <!-- Дата и время -->
                            <div class="flex items-center bg-blue-50 p-3 rounded-lg">
                                <svg class="w-5 h-5 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="font-medium">
                                    {{ $event->date->translatedFormat('j F Y') }}
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
                        
                        <!-- Индикатор активного события -->
                        @if($event->status === 'active')
                        <div class="absolute top-2 left-2 flex items-center bg-green-600 text-white px-3 py-1 rounded-full text-sm font-bold animate-pulse">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                            </svg>
                            Активно
                        </div>
                        @endif
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
   