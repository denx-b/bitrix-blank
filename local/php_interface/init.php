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
AddEventHandler('iblock', 'OnBeforeIBlockElementUpdate', ['\Dbogdanoff\Events\Iblock', 'beforeIBlockElementUpdateHandler']);

/*
 * Событие при выводе буферизированного контента.
 * Обработчик минифицирует html
 */
AddEventHandler('main', 'OnEndBufferContent', ['\Dbogdanoff\Events\Main', 'endBufferContentHandler']);

/*
 * Событие в выполняемой части пролога сайта
 * Обработчик активирует API
 */
AddEventHandler('main', 'OnBeforeProlog', ['\Dbogdanoff\Events\Main', 'initApi']);
