<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>
            @yield('title')
        </title>

        <script src="https://api-maps.yandex.ru/2.1/?apikey={{ config('services.yandex.maps_key') }}&lang=ru_RU"></script>

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Exo+2:wght@400;500;600;700&display=swap" rel="stylesheet">

        <style>
            /* Кастомизация стилей */
            .swiper-pagination-bullet {
                @apply bg-white opacity-80 w-3 h-3 transition;
            }
            .swiper-pagination-bullet-active {
                @apply opacity-100 bg-blue-500 scale-125;
            }
            
            /* Применение шрифтов */
            h1, h2, h3, h4, h5, h6 {
                font-family: 'Exo 2', sans-serif;
            }
            
            body {
                font-family: 'Montserrat', sans-serif;
            }
        </style>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            @if(session('success'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4" role="alert">
                        <div class="flex">
                            <div class="py-1">
                                <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p class="font-bold">Успешно!</p>
                                <p>{{ session('success') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            @error('exception')
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <div class="bg-green-100 border-l-4 border-red-500 text-red-700 p-4 mb-4" role="alert">
                        <div class="flex">
                            <div class="py-1">
                                <svg class="w-6 h-6 mr-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <p>{{ $message }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @enderror


            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>

            <footer class="bg-blue-900 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
                <div class="grid md:grid-cols-4 gap-8 mb-8">
                    <!-- Лого и описание -->
                    <div class="space-y-4">
                        <a href="{{ route('main') }}" class="flex items-center">
                            <img src="{{ asset('images/dark-logo.jpg') }}" alt="START logo" class="h-10 w-auto fill-current text-white">
                            <span class="ml-3 text-xl font-bold">START</span>
                        </a>
                        <p class="text-sm opacity-80">
                            Платформа для организации и участия в спортивных мероприятиях
                        </p>
                    </div>

                    <!-- Навигация -->
                    <div class="space-y-3">
                        <h3 class="text-lg font-semibold mb-3">Навигация</h3>
                        <ul class="space-y-2">
                            @if(Auth::user()->is_admin)
                                <li><a href="{{ route('dashboard') }}" class="hover:text-blue-300 transition-colors">Панель управления</a></li>
                                <li><a href="{{ route('reports.index') }}" class="hover:text-blue-300 transition-colors">Жалобы</a></li>
                                <li><a href="{{ route('feedbacks.index') }}" class="hover:text-blue-300 transition-colors">Обращения</a></li>
                            @else
                                <li><a href="{{ route('main') }}" class="hover:text-blue-300 transition-colors">Главная</a></li>
                                <li><a href="{{ route('events.index') }}" class="hover:text-blue-300 transition-colors">События</a></li>
                                <li><a href="{{ route('feedbacks.create') }}" class="hover:text-blue-300 transition-colors">Обратная связь</a></li>
                            @endif
                            <li><a href="{{ route('profile.edit') }}" class="hover:text-blue-300 transition-colors">Профиль</a></li>
                        </ul>
                    </div>

                    <!-- Контакты -->
                    <div class="space-y-3">
                        <h3 class="text-lg font-semibold mb-3">Контакты</h3>
                        <ul class="space-y-2">
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                support@sportevents.ru
                            </li>
                            <li class="flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                                </svg>
                                +7 (495) 123-45-67
                            </li>
                        </ul>
                    </div>

                    <!-- Соцсети -->
                    <div class="space-y-3">
                        <h3 class="text-lg font-semibold mb-3">Мы в соцсетях</h3>
                        <div class="flex space-x-4">
                            <a href="#" class="p-2 bg-blue-800 rounded-full hover:bg-blue-700 transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/>
                                </svg>
                            </a>
                            <a href="#" class="p-2 bg-blue-800 rounded-full hover:bg-blue-700 transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm3 8h-1.35c-.538 0-.65.221-.65.778v1.222h2l-.209 2h-1.791v7h-3v-7h-2v-2h2v-2.308c0-1.769.931-2.692 3.029-2.692h1.971v3z"/>
                                </svg>
                            </a>
                            <a href="#" class="p-2 bg-blue-800 rounded-full hover:bg-blue-700 transition-colors">
                                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Копирайт -->
                <div class="border-t border-blue-800 pt-8 text-center text-sm opacity-80">
                    © {{ date('Y') }} START. Все права защищены
                </div>
            </div>
        </footer>
        </div>
    </body>
</html>
