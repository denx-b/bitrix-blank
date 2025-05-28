<?php

namespace Legacy\Service;

class Str
{
    /**
     * Мастхэв для обработки всех строк вводимых пользователями в формах
     *     – Заменяет случайные двойные пробелы на одинарные
     *     – Удаляет теги
     *     – Делает trim
     *     – Опционально преобразует спец символы в HTML-сущности, чтобы предотвратить XSS-атаки (Cross-Site Scripting)
     *
     * @param $str
     * @param bool $specialchars
     * @param $allowed_tags
     * @return string
     */
    public static function filterString($str, bool $specialchars = false, $allowed_tags = null): string
    {
        $str = strip_tags($str, $allowed_tags);
        $str = preg_replace('/ {2,}/', ' ', $str);
        $str = trim($str);

        if ($specialchars === true) {
            return htmlspecialchars($str);
        }

        return $str;
    }

    /**
     * Подготовка строки для использования в js-функции alert()
     * Основная проблема это теги и симвоыл переноса
     * Функция фильтрует теги и заменяет <br> на \n
     *
     * @param $message
     * @return string
     */
    public static function filterToAlert($message): string
    {
        $removedTags = strip_tags(preg_replace('/<br(.*)?>/', '\n', $message));
        return self::filterString($removedTags);
    }

    /**
     * Метод склонят число по входящему массиву
     *
     * @param $n
     * @param $titles
     * @return mixed
     */
    public static function num2word($n, $titles)
    {
        $cases = [2, 0, 1, 1, 1, 2];
        return $titles[($n % 100 > 4 && $n % 100 < 20) ? 2 : $cases[min($n % 10, 5)]];
    }

    /**
     * Пример использования self::num2word на примере Лет
     *
     * @param $year
     * @return mixed
     */
    public static function year2word($year)
    {
        return self::num2word($year, ['год', 'года', 'лет']);
    }

    /**
     * @param $text
     * @return string
     */
    public static function filterToFeed($text): string
    {
        if (!$text) {
            return '';
        }

        $arReplace = array(
            "&quot;" => '"',
            "&amp;" => "&",
            "&gt;" => ">",
            "&lt;" => "<",
            "&apos;" => "'"
        );

        return str_replace($arReplace, array_flip($arReplace), self::filterString($text));
    }

    /**
     * Извлекает код видео из URL YouTube.
     *
     * @param string $url URL видео на YouTube.
     * @return string|null Код видео или null, если код не найден.
     */
    public static function extractVideoCode(string $url): ?string
    {
        $patterns = [
            '/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', // Стандартный формат
            '/youtube\.com\/watch\?.*v=([a-zA-Z0-9_-]+)&.*/', // С параметрами
            '/youtu\.be\/([a-zA-Z0-9_-]+)/' // Короткий формат
        ];

        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $url, $matches)) {
                return $matches[1];
            }
        }

        return null; // Возвращает null, если код не найден
    }
}
