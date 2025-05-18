<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h2 class="text-2xl font-semibold mb-6">Просмотр обращения #{{ $report->id }}</h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Отправитель</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $report->user->name }} ({{ $report->user->email }})</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Событие</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $report->event->title }}</p>
                            <p class="text-sm text-gray-500">{{ $report->event->date->format('d.m.Y H:i') }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Дата обращения</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $report->created_at->format('d.m.Y H:i') }}</p>
                        </div>
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Статус</h3>
                            <p class="mt-1 text-sm">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    @if($report->status === 'accepted')
                                        bg-green-100 text-green-800
                                    @elseif($report->status === 'rejected')
                                        bg-red-100 text-red-800
                                    @else
                                        bg-yellow-100 text-yellow-800
                                    @endif">
                                    @if($report->status === 'accepted')
                                        Принято
                                    @elseif($report->status === 'rejected')
                                        Отклонено
                                    @else
                                        В обработке
                                    @endif
                                </span>
                            </p>
                        </div>
                        <div class="md:col-span-2">
                            <h3 class="text-lg font-medium text-gray-900">Причина обращения</h3>
                            <p class="mt-1 text-sm text-gray-600">{{ $report->message }}</p>
                        </div>
                    </div>

                    @if($report->status === 'processing')
                        <div class="mt-6 flex justify-end space-x-3">
                            <form action="{{ route('reports.accept', $report->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Рассмотреть и принять
                                </button>
                            </form>
                             <form action="{{ route('reports.reject', $report->id) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-colors duration-200">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                    Отклонить
                                </button>
                            </form>
                        </div>
                    @endif

                    <div class="mt-8">
                        <a href="{{ route('reports.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-colors duration-200">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Назад к списку
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 