@section('title', 'Редактировать событие')
<x-app-layout>
    <form method="POST" action="{{ route('events.update', $event) }}" enctype="multipart/form-data" class="max-w-2xl mx-auto bg-white rounded-xl shadow-md p-6 my-6 space-y-6">
        @csrf
        @method('PUT')

        <h2 class="text-3xl font-bold text-gray-800 text-center">Редактирование события</h2>
        
        <!-- Название события -->
        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Название события</label>
            <input type="text" id="title" name="title" value="{{ old('title', $event->title) }}" required 
                class="w-full px-4 py-2 rounded-lg border @error('title') border-red-500 @else border-gray-300 @enderror focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200 transition duration-200"
                placeholder="Введите название события">
            @error('title')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <!-- Дата и время -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Дата</label>
                <div class="relative">
                    <input type="date" id="date" name="date" value="{{ old('date', $event->date->format('Y-m-d')) }}" required 
                        class="w-full px-4 py-2 rounded-lg border @error('date') border-red-500 @else border-gray-300 @enderror focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                    <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
                @error('date')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="start_time" class="block text-sm font-medium text-gray-700 mb-2">Начало</label>
                <input type="time" id="start_time" name="start_time" value="{{ old('start_time', $event->start_time->format('H:i')) }}" required 
                    class="w-full px-4 py-2 rounded-lg border @error('start_time') border-red-500 @else border-gray-300 @enderror focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                @error('start_time')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="end_time" class="block text-sm font-medium text-gray-700 mb-2">Окончание</label>
                <input type="time" id="end_time" name="end_time" value="{{ old('end_time', $event->end_time->format('H:i')) }}" required 
                    class="w-full px-4 py-2 rounded-lg border @error('end_time') border-red-500 @else border-gray-300 @enderror focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                @error('end_time')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Участники и вид спорта -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="max_participant" class="block text-sm font-medium text-gray-700 mb-2">Макс. участников</label>
                <input type="number" id="max_participant" name="max_participant" min="2" value="{{ old('max_participant', $event->max_participant) }}" required 
                    class="w-full px-4 py-2 rounded-lg border @error('max_participant') border-red-500 @else border-gray-300 @enderror focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                    placeholder="Введите количество">
                @error('max_participant')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="sport_id" class="block text-sm font-medium text-gray-700 mb-2">Вид спорта</label>
                <select id="sport_id" name="sport_id" required 
                        class="w-full px-4 py-2 rounded-lg border @error('sport_id') border-red-500 @else border-gray-300 @enderror focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200">
                    <option value="">Выберите вид спорта</option>
                    @foreach($sports as $sport)
                        <option value="{{ $sport->id }}" {{ old('sport_id', $event->sport_id) == $sport->id ? 'selected' : '' }}>{{ $sport->name }}</option>
                    @endforeach
                </select>
                @error('sport_id')
                    <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Адрес и карта -->
        <div>
            <label for="address" class="block text-sm font-medium text-gray-700 mb-2">Адрес</label>
            <input type="text" id="address" name="address" readonly required
                class="w-full px-4 py-2 rounded-lg border @error('latitude', 'longitude', 'address') border-red-500 @else border-gray-300 @enderror bg-gray-50 cursor-not-allowed"
                value="{{ old('address', $event->address) }}">
            @error('address')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <input type="hidden" id="latitude" name="latitude" value="{{ old('latitude', $event->latitude) }}">
        <input type="hidden" id="longitude" name="longitude" value="{{ old('longitude', $event->longitude) }}">

        <div id="map" style="height: 300px;" class="rounded-lg border border-gray-200 overflow-hidden"></div>

        <!-- Комментарий -->
        <div>
            <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Дополнительная информация</label>
            <textarea id="comment" name="comment" rows="3"
                    class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-indigo-500 focus:ring-2 focus:ring-indigo-200"
                    placeholder="Опишите детали события">{{ old('comment', $event->comment) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">Загрузка изображений</label>
            <div id="drop-zone" 
                class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dashed rounded-md hover:border-indigo-500 transition-colors duration-200
                        @error('images.*') border-red-500 @else border-gray-300 @enderror">
                <div class="space-y-1 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" 
                            stroke-width="2" 
                            stroke-linecap="round" 
                            stroke-linejoin="round" />
                    </svg>
                    <div class="flex text-sm text-gray-600">
                        <label for="images" class="relative cursor-pointer bg-white rounded-md font-medium text-indigo-600 hover:text-indigo-500 focus-within:outline-none focus-within:ring-2 focus-within:ring-offset-2 focus-within:ring-indigo-500">
                            <span>Загрузите файлы</span>
                            <input id="images" name="images[]" type="file" multiple accept="image/*" 
                                class="sr-only">
                        </label>
                        <p class="pl-1">или перетащите их сюда</p>
                    </div>
                    <p class="text-xs text-gray-500">
                        PNG, JPG, JPEG (максимум 5 МБ каждый)
                    </p>
                    <div id="file-counter" class="text-sm text-gray-500 mt-2 hidden">
                        Выбрано файлов: <span id="count">0</span>
                    </div>
                </div>
            </div>
            
            @error('images.*')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
            @error('images')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror

            <!-- Существующие изображения -->
            @if($images)
                <div class="mt-4">
                    <h3 class="text-sm font-medium text-gray-700 mb-2">Текущие изображения</h3>
                    <div class="grid grid-cols-3 gap-4">
                        @foreach($images as $image)
                            <div class="relative group">
                                <div class="absolute top-2 left-2 z-10">
                                    <input type="checkbox" name="deleted_images[]" value="{{ $image }}" 
                                           class="w-5 h-5 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500">
                                </div>
                                <img src="{{ $image }}" alt="Изображение события" class="w-full h-32 object-cover rounded-lg">
                                <div class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-200 rounded-lg flex items-center justify-center">
                                    <span class="text-white text-sm">Отметьте для удаления</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        <!-- Кнопки действий -->
        <div class="flex space-x-4">
            <button type="submit" 
                    class="flex-1 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition duration-200 transform hover:scale-101">
                Сохранить изменения
            </button>
            <a href="{{ route('events.show', $event) }}" 
               class="flex-1 bg-gray-500 hover:bg-gray-600 text-white font-semibold py-2 px-4 rounded-lg transition duration-200 transform hover:scale-101 text-center">
                Отмена
            </a>
        </div>
    </form>
</x-app-layout>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const dropZone = document.getElementById('drop-zone');
        const fileInput = document.getElementById('images');
        const fileCounter = document.getElementById('file-counter');
        const countSpan = document.getElementById('count');

        // Обработчики для drag-and-drop
        dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropZone.classList.add('border-indigo-500', 'bg-indigo-50');
        });

        dropZone.addEventListener('dragleave', () => {
            dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
        });

        dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropZone.classList.remove('border-indigo-500', 'bg-indigo-50');
            
            const files = e.dataTransfer.files;
            if (files.length) {
                // Добавляем новые файлы к существующим
                const newFiles = new DataTransfer();
                for (const file of fileInput.files) {
                    newFiles.items.add(file);
                }
                for (const file of files) {
                    newFiles.items.add(file);
                }
                fileInput.files = newFiles.files;
                
                // Триггерим событие изменения
                fileInput.dispatchEvent(new Event('change'));
            }
        });

        // Обновление счетчика при выборе файлов
        fileInput.addEventListener('change', () => {
            const files = fileInput.files;
            countSpan.textContent = files.length;
            fileCounter.classList.toggle('hidden', files.length === 0);
        });

        // Обработка отправки формы
        document.querySelector('form').addEventListener('submit', function(e) {
            const checkedImages = document.querySelectorAll('input[name="deleted_images[]"]:checked');
            if (checkedImages.length > 0) {
                if (!confirm(`Вы уверены, что хотите удалить ${checkedImages.length} изображений?`)) {
                    e.preventDefault();
                }
            }
        });
    });
</script>

<script type="text/javascript">
    ymaps.ready(init);

    function init() {
        var myMap = new ymaps.Map("map", {
            center: [{{ $event->latitude }}, {{ $event->longitude }}],
            zoom: 12
        });

        var placemark = createPlacemark([{{ $event->latitude }}, {{ $event->longitude }}]);
        myMap.geoObjects.add(placemark);

        // Обработчик клика по карте
        myMap.events.add('click', function(e) {
            var coords = e.get('coords');

            if (!isValidCoordinates(coords)) {
                console.error('Некорректные координаты:', coords);
                return;
            }

            placemark.geometry.setCoordinates(coords);
            updateAddress(coords);
        });

        // Валидация координат
        function isValidCoordinates(coords) {
            return coords && 
            typeof coords[0] === 'number' &&
            typeof coords[1] === 'number' &&
            Math.abs(coords[0]) <= 90 &&
            Math.abs(coords[1]) <= 180;
        }

        // Создание метки
        function createPlacemark(coords) {
            var pm = new ymaps.Placemark(coords, {}, {
                draggable: true,
                preset: 'islands#redDotIcon'
            });
            
            pm.events.add('dragend', function() {
                updateAddress(pm.geometry.getCoordinates());
            });
            
            return pm;
        }

        // Обновление адреса
        function updateAddress(coords) {
            if (
                !coords ||
                !Array.isArray(coords) ||
                coords.length !== 2 ||
                typeof coords[0] !== 'number' ||
                typeof coords[1] !== 'number'
            ) {
                console.error('Некорректные координаты:', coords);
                document.getElementById('address').value = 'Ошибка в координатах';
                return;
            }

            document.getElementById('latitude').value = coords[0].toFixed(6);
            document.getElementById('longitude').value = coords[1].toFixed(6);

            ymaps.geocode(coords, {
                results: 1
            }).then(function(res) {
                var geoObjects = res.geoObjects;
                if (geoObjects.getLength() === 0) {
                    document.getElementById('address').value = 'Адрес не найден';
                    return;
                }

                var firstGeoObject = geoObjects.get(0);
                var addressLine = firstGeoObject.getAddressLine();

                document.getElementById('address').value = addressLine || 'Адрес не определён';
            }).catch(function(err) {
                console.error('Полная ошибка геокодирования:', {
                    error: err,
                    coordinates: coords,
                    timestamp: new Date().toISOString()
                });
                document.getElementById('address').value = 'Не удалось определить адрес';
            });
        }
    }

    function deleteImage(imageUrl) {
        if (confirm('Вы уверены, что хотите удалить это изображение?')) {
            console.log(imageUrl);
        }
    }
</script>