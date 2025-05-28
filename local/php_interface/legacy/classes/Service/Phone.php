<?php

namespace Legacy\Service;

class Phone
{
    public static function filterPhoneNumber($phoneNumber, $ru = true): string
    {
        if (LANGUAGE_ID === 'ru' && $ru === true) {
            return self::filterPhoneNumberRu($phoneNumber);
        }
        return self::filterPhoneNumberOther($phoneNumber);
    }

    /**
     * @param $phoneNumber
     * @return string
     */
    protected static function filterPhoneNumberRu($phoneNumber): string
    {
        $phoneNumber = Str::filterString($phoneNumber);

        // Удаляем все кроме цифр
        $phoneNumber = preg_replace('/\D/', '', $phoneNumber);

        // Заменяем начальную '8' на '+7', если строка начинается с '8'
        if (strpos($phoneNumber, '8') === 0) {
            $phoneNumber = '+7' . substr($phoneNumber, 1);
        } elseif (strpos($phoneNumber, '9') === 0) {
            $phoneNumber = '+7' . $phoneNumber;
        } else {
            $phoneNumber = '+' . $phoneNumber;
        }

        return $phoneNumber;
    }

    /**
     * @param $phoneNumber
     * @return string
     */
    protected static function filterPhoneNumberOther($phoneNumber): string
    {
        $phoneNumber = Str::filterString($phoneNumber);

        $hasPlus = str_contains($phoneNumber, '+');

        // Удаляем все кроме цифр
        $phoneNumber = preg_replace('/\D/', '', $phoneNumber);

        if ($hasPlus) {
            $phoneNumber = '+' . $phoneNumber;
        }

        return $phoneNumber;
    }
}
