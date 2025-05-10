<?php

namespace App\Http\Requests\Event;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'max_participant' => 'required|integer|min:1',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'comment' => 'nullable|string',
            'address' => 'required|string|max:500',
            'latitude' => ['required', 'regex:/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/'],
            'longitude' => ['required', 'regex:/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/'],
            'sport_id' => 'required|exists:sports,id',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'deleted_images' => 'nullable|array',
            'deleted_images.*' => 'string|max:500',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'title.required' => 'Название события обязательно для заполнения',
            'title.max' => 'Название события не может быть длиннее 255 символов',
            'max_participant.required' => 'Количество участников обязательно для заполнения',
            'max_participant.min' => 'Минимальное количество участников - 1',
            'date.required' => 'Дата события обязательна для заполнения',
            'date.after_or_equal' => 'Дата события не может быть в прошлом',
            'start_time.required' => 'Время начала обязательно для заполнения',
            'start_time.date_format' => 'Неверный формат времени начала',
            'end_time.required' => 'Время окончания обязательно для заполнения',
            'end_time.date_format' => 'Неверный формат времени окончания',
            'end_time.after' => 'Время окончания должно быть позже времени начала',
            'address.required' => 'Адрес обязателен для заполнения',
            'address.max' => 'Адрес не может быть длиннее 500 символов',
            'latitude.required' => 'Широта обязательна для заполнения',
            'latitude.regex' => 'Неверный формат широты',
            'longitude.required' => 'Долгота обязательна для заполнения',
            'longitude.regex' => 'Неверный формат долготы',
            'sport_id.required' => 'Вид спорта обязателен для выбора',
            'sport_id.exists' => 'Выбранный вид спорта не существует',
            'images.*.image' => 'Файл должен быть изображением',
            'images.*.mimes' => 'Изображение должно быть в формате: jpeg, png, jpg, webp',
            'images.*.max' => 'Размер изображения не может превышать 5 МБ',
        ];
    }
}
