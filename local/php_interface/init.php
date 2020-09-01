<?php

// composer
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/vendor/autoload.php';

// autoload
require_once __DIR__ . '/include/autoload.php';

// функции для разработчика
require_once __DIR__ . '/include/functions.php';

/*
 * Событие до изменения элемента информационного блока
 * Обработчик в зависимости от ID инфоблока выполняет нужные дейтсвия
 */
AddEventHandler('iblock', 'OnBeforeIBlockElementUpdate',
    ['\Dbogdanoff\Events\Iblock', 'beforeIBlockElementUpdateHandler']);

// remove index.php
if (strpos($_SERVER['REQUEST_URI'], '/bitrix') === false && strpos($_SERVER['REQUEST_URI'], '/local') === false) {
    if (preg_match("/(.*)\/index.php(.*)/", $_SERVER['REQUEST_URI'], $matches)) {
        LocalRedirect($matches[1] . '/' . $matches[2], false, '301 Moved permanently');
    }
}

// Агенты на кроне
if (!(defined('CHK_EVENT') && CHK_EVENT === true)) {
    define('BX_CRONTAB_SUPPORT', true);
}

// Настройка логирования php-ошибок
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', '0');
ini_set('log_errors', 'On');
ini_set('error_log', $_SERVER['DOCUMENT_ROOT'] . '/upload/php-exception-log-txt');
