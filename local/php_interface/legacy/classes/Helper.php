<?php

namespace Legacy;

use CUser;
use Bitrix\Main\Application;
use Exception;

class Helper
{
    /**
     * Метод возвращает true если у текущего пользователя есть доступ в админку
     * @return bool
     */
    public static function checkAdminAccess(): bool
    {
        $user = new CUser();
        if (!$user->IsAuthorized()) {
            return false;
        }

        if ($user->IsAdmin()) {
            return true;
        }

        $arGroups = $user->GetUserGroupArray();

        /** @var array $PERM */
        include $_SERVER['DOCUMENT_ROOT'] . '/bitrix/.access.php';

        $arAccess = [];
        foreach($PERM['admin'] as $group_id => $access) {
            if ($access == 'R' && is_numeric($group_id)) {
                $arAccess[$group_id] = true;
            }
        }

        foreach ($arGroups as $group_id) {
            if ($arAccess[$group_id] === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * Используется в шаблоне сайта.
     * Возвращает true, если содержимое страницы нужно оборачивать в контейнер.
     * Страницы, где нужно спрятать контейнер, перечисляются в settings.php в массиве HIDE_CONTAINER
     * 
     * @return bool
     */
    public static function containerShow(): bool
    {
        global $APPLICATION;

        $curPage = $APPLICATION->GetCurPage(false);

        foreach (HIDE_CONTAINER as $rule) {
            if (fnmatch($rule, $curPage)) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param $str
     * @param bool $specialchars
     * @return string
     */
    public static function filterString($str, bool $specialchars = true): string
    {
        $str = strip_tags($str);
        $str = preg_replace('/\s+/', ' ', $str);
        $str = trim($str);

        if ($specialchars === false) {
            return $str;
        }

        return htmlspecialchars($str);
    }

    /**
     * @param $phoneNumber
     * @return string
     */
    public static function filterPhoneNumber($phoneNumber) {
        $phoneNumber = self::filterString($phoneNumber, false);

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

        return str_replace($arReplace, array_flip($arReplace), self::filterString($text, false));
    }

    /**
     * CURL-запрос
     * Возможно указать POST или Proxy при необходимости
     *
     * @param string $queryUrl
     * @param array $queryData
     * @param bool $post
     * @param string $proxy
     * @param string $proxy_login
     * @return bool|string
     */
    public static function curl(string $queryUrl, array $queryData = [], bool $post = false, string $proxy = '', string $proxy_login = '')
    {
        $curl = curl_init();

        if ($post !== true) {
            if (count($queryData)) {
                $sep = strpos($queryUrl, '?') !== false ? '&' : '?';
                $queryUrl .= $sep . http_build_query($queryData);
            }
        } else {
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $queryData);
        }

        curl_setopt_array($curl, [
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_HEADER => false,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_URL => $queryUrl
        ]);

        if ($proxy) {
            curl_setopt($curl, CURLOPT_PROXY, $proxy);
        }

        if ($proxy_login) {
            curl_setopt($curl, CURLOPT_PROXYUSERPWD, $proxy_login);
        }

        $result = curl_exec($curl);
        curl_close($curl);

        return $result;
    }

    /**
     * Генерация сообщений, чаще всего в ajax-скриптах
     *
     * @param bool $success
     * @param string $message
     * @param array $data
     * @param bool $die
     * @return array|void
     */
    public static function jsonMessage(bool $success = true, string $message = 'ok', array $data = [], bool $die = true)
    {
        $fields = ['SUCCESS' => $success, 'MESSAGE' => $message] + $data;

        if ($die === true) {
            echo json_encode($fields);
            die;
        } else {
            return $fields;
        }
    }

    /**
     * Метод возвращает путь текущей стр. сайта с доменом и протоколом
     *
     * @return string
     * @throws Exception
     */
    public static function getHttpPath(): string
    {
        $request = Application::getInstance()->getContext();
        return strtok($request->getRequest()->getRequestUri(), '?');
    }

    /**
     * Метод возвращает домен с протоколом
     *
     * @return string
     * @throws Exception
     */
    public static function getServerName(): string
    {
        $request = Application::getInstance()->getContext();

        $url = $request->getRequest()->isHttps() ? 'https://' : 'http://';
        $url .= $request->getServer()->getServerName();

        return $url;
    }

    /**
     * Проверка строки на валидность даты заданного формата
     *
     * @param $date
     * @param string $format
     * @return bool
     */
    public static function check_date($date, $format = 'd.m.Y H:i'): bool
    {
        $d = \DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) == $date;
    }

    /**
     * Проверка url-адреса на валидность
     *
     * @param $url
     * @return bool
     */
    public static function check_url($url)
    {
        return preg_match('/^(http(s?):\/\/)?(((www\.)?+[a-zA-Z0-9\.\-\_]+(\.[a-zA-Z]{2,3})+)|(\b(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\b))(\/[a-zA-Z0-9\_\-\s\.\/\?\%\#\&\=]*)?$/i', $url);
    }

    public static function check_email($mail): bool
    {
        return filter_var($mail, FILTER_VALIDATE_EMAIL) && strpos($mail, 'example.com') === false && strpos($mail,
                $_SERVER['SERVER_NAME']);
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
     * true если на сайте робот гугла
     * @return bool
     */
    public static function isGoogle()
    {
        if (strstr(strtolower($_SERVER['HTTP_USER_AGENT']), "googlebot")) {
            return true;
        }

        return false;
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
