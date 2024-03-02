<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function messages()
    {
        return [
            'required' => 'Поле обязательно для заполнения.',
            'min' => 'Поле должно быть не менее :min символов.',
            'max' => 'Поле должно быть не более :max символов.',
            'alpha' => 'Поле должно содержать только буквы.',
            'email' => 'Не корректный адресс электронной почты.',
            'not_in' => [
                0 => 'Поле обязательно для заполнения.',
            ],
            'required_without_all' => [
                'email,phone' => 'Поле телефона является обязательным, если не указан адрес электронной почты.'
            ],
            'files.max' => 'Максимальное количество файлов: :max.',
            'files.mimes' => 'Допустимые типы файлов: JPG, PNG, PDF.',
            'files.*.max' => 'Размер файла не должен превышать 5 Мб.',
        ];
    }

}
