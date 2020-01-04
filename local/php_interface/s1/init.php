<?php
require_once 'include/autoload.php';

/*
 * Событие перед отправкой письма из модуля рассылки
 * Обработчик подменяет поля
 */
AddEventHandler('subscribe', 'BeforePostingSendMail',
    ['\Dbogdanoff\Events\Subscribe', 'beforePostingSendMailHandler']);

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
