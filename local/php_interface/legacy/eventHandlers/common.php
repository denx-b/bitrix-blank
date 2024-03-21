<?php

/*
 * Обработчик активирует API
 * Событие в выполняемой части пролога сайта
 */
AddEventHandler('main', 'OnBeforeProlog', ['\Legacy\Events\Main', 'initApi']);

/*
 * Обработчик минифицирует html
 * Событие при выводе буферизированного контента.
 */
AddEventHandler('main', 'OnEndBufferContent', ['\Legacy\Events\Main', 'endBufferContentHandler']);
