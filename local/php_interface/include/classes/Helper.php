<?php

namespace Dbogdanoff;

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
        include $_SERVER['DOCUMENT_ROOT'] .'/bitrix/.access.php';

        $arAccess = [];
        foreach($PERM['admin'] as $group_id => $access) {
            if ($access == 'R' && is_numeric($group_id)) {
                $arAccess[ $group_id ] = true;
            }
        }

        foreach ($arGroups as $group_id) {
            if ($arAccess[ $group_id ] === true) {
                return true;
            }
        }

        return false;
    }

    /**
     * CURL-запрос
     * Возможно указать POST или Proxy при необходимости
     *
     * @param $queryUrl
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
     * @param $success
     * @param $message
     * @param bool $die
     * @param $data
     *
     * @return array|string
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
     * Пример испольования self::num2word на примере Лет
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
}
