@section('title', 'Главная страница')
<x-app-layout>
    <div class="relative min-h-screen">
        <!-- Hero Section -->
        <div class="relative h-screen flex items-center justify-center">
            <div class="absolute inset-0">
                <img src="{{ asset('2.jpg') }}" 
                     alt="Спортивные мероприятия" 
                     class="w-full h-full object-cover opacity-90">
                <div class="absolute inset-0 bg-blue-900 mix-blend-multiply"></div>
            </div>
            
            <div class="relative max-w-7xl px-4 text-center text-white">
                <h1 class="text-4xl md:text-6xl font-bold mb-6 animate-fade-in-down">
                    Организуй свой спортивный успех
                </h1>
                <p class="text-xl md:text-2xl mb-8 max-w-2xl mx-auto">
                    Платформа для создания и участия в спортивных событиях. Беги, соревнуйся, побеждай!
                </p>
                <a href="{{ route('events.index') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-lg text-lg font-semibold transition-all transform hover:scale-105">
                    Начать сейчас
                </a>
            </div>
        </div>

        <!-- Features Grid -->
        <div class="py-16 bg-blue-50">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-3xl md:text-4xl font-bold text-center text-blue-900 mb-12">
                    Почему выбирают нас
                </h2>
                
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Card 1 -->
                    <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Мгновенная регистрация</h3>
                        <p class="text-gray-600">Участвуйте в мероприятиях за 2 клика с автоматической системой отчетности</p>
                    </div>

                    <!-- Card 2 -->
                    <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Сообщество</h3>
                        <p class="text-gray-600">Более 50,000 активных участников и 1000 организаторов</p>
                    </div>

                    <!-- Card 3 -->
                    <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mb-4">
                            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Статистика</h3>
                        <p class="text-gray-600">Подробная аналитика и персональные рекомендации</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- CTA Section -->
        <div class="relative py-24 bg-blue-900 text-white">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <h2 class="text-3xl md:text-4xl font-bold mb-6">Готовы к старту?</h2>
                <p class="text-xl mb-8 max-w-2xl mx-auto">Присоединяйтесь к крупнейшему спортивному сообществу прямо сейчас</p>
                <div class="space-x-4">
                    <a href="{{ route('register') }}" class="inline-block bg-white text-blue-900 px-8 py-3 rounded-lg text-lg font-semibold hover:bg-blue-50 transition-colors">
                        Найти  событие
                    </a>
                    <a href="#" class="inline-block border-2 border-white px-8 py-3 rounded-lg text-lg font-semibold hover:bg-white hover:text-blue-900 transition-colors">
                        Узнать больше
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="py-16 bg-blue-50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="bg-white shadow-xl rounded-2xl p-8 md:p-12">
                    <h2 class="text-3xl md:text-4xl font-bold text-blue-900 mb-8 text-center">
                        Обратная связь
                    </h2>
                    
                    <form method="POST" action="{{ route('feedbacks.store') }}" class="space-y-6 max-w-2xl mx-auto">
                        @csrf

                        <div>
                            <label for="message" class="block text-lg font-medium text-gray-700 mb-3">
                                Ваше сообщение
                            </label>
                            <textarea 
                                id="message" 
                                name="message" 
                                rows="5"
                                required
                                class="w-full rounded-lg border-2 border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 
                                       transition duration-200 ease-in-out text-lg p-4
                                       @error('message') border-red-500 @enderror"
                                placeholder="Напишите ваши предложения"
                            >{{ old('message') }}</textarea>
                            
                            @error('message')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="inline-flex items-center px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white 
                                           text-lg font-semibold rounded-lg transition-all 
                                           transform hover:scale-105 focus:outline-none focus:ring-4 
                                           focus:ring-blue-500 focus:ring-opacity-50">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M2 5a2 2 0 012-2h7a2 2 0 012 2v4a2 2 0 01-2 2H9l-3 3v-3H4a2 2 0 01-2-2V5z" />
                                    <path d="M15 7v2a4 4 0 01-4 4H9.828l-1.766 1.767c.28.149.599.233.938.233h2l3 3v-3h2a2 2 0 002-2V9a2 2 0 00-2-2h-1z" />
                                </svg>
                                Отправить
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>