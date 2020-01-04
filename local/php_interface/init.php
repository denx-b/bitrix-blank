<?php

// composer
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/vendor/autoload.php';

// функции для разработчика
require_once __DIR__ . '/include/functions.php';

// Агенты на кроне
if (!(defined('CHK_EVENT') && CHK_EVENT === true)) {
    define('BX_CRONTAB_SUPPORT', true);
}

// Настройка логирования php-ошибок
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set('display_errors', '0');
ini_set('error_log', $_SERVER['DOCUMENT_ROOT'] . '/upload/php-exception-log-txt');
