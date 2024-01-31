<?php

/*
 * Событие до изменения элемента информационного блока
 * Обработчик в зависимости от ID инфоблока выполняет нужные дейтсвия
 */
AddEventHandler('iblock', 'OnBeforeIBlockElementUpdate', ['\Legacy\Events\Iblock', 'beforeIBlockElementUpdateHandler']);

/*
 * Событие при выводе буферизированного контента.
 * Обработчик минифицирует html
 */
AddEventHandler('main', 'OnEndBufferContent', ['\Legacy\Events\Main', 'endBufferContentHandler']);

/*
 * Событие в выполняемой части пролога сайта
 * Обработчик активирует API
 */
AddEventHandler('main', 'OnBeforeProlog', ['\Legacy\Events\Main', 'initApi']);
