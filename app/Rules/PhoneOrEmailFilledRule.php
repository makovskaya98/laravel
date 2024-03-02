<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneOrEmailFilledRule implements ValidationRule
{
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $data = $this->data;

        $hasFilledPhone = false;

        $error = '';

        foreach ($data['phonenumbers'] as $phone) {

            if (isset($phone['countrycode']) && !empty($phone['countrycode']) && isset($phone['phone']) && !empty($phone['phone'])) {

                if (preg_match('/^[0-9 ()-]+$/', $phone['phone'])) {

                    $replace_phone = mb_strlen(preg_replace("/[\s\(\)\-]/", "", $phone['phone']));

                    switch ($phone['countrycode']) {
                        case '+375':

                            if ($replace_phone != 9) {
                                $error = 'Номер телефона должен содержать 9 цифр.';
                            }
                            break;
                        case '+7':
                            if ($replace_phone != 10) {
                                $error = 'Номер телефона должен содержать 10 цифр.';
                            }
                            break;
                    }

                    if (empty($error)) {
                        $hasFilledPhone = true;
                    } else {
                        $fail($error);
                    }

                } else {
                    $fail('Номер телефона не может содержать буквы или другие символы.');
                }
            }
        }

        if (!$hasFilledPhone && empty($data['email'])) {
            $fail('Введите хотя бы один номер телефона или email.');
        }
    }
}
