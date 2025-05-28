<?php

namespace Legacy\Service;

use CUser;
use Bitrix\Main\Application;
use Exception;

class Common
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

        if (!defined('HIDE_CONTAINER') || !is_array(HIDE_CONTAINER)) {
            return true;
        }

        foreach (HIDE_CONTAINER as $rule) {
            if (fnmatch($rule, $curPage)) {
                return false;
            }
        }

        return true;
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
