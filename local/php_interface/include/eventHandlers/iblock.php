<?php

use Bitrix\Main\Loader;

/**
 * В данном файле приведён пример регистрации обработчиков события обновления элемента инфоблока
 */

if (!Loader::includeModule('iblock')) {
    return;
}

/*
 * Метод запрещает изменять элементы не авторам
 * Событие до изменения элемента информационного блока
 */
AddEventHandler('iblock', 'OnBeforeIBlockElementUpdate', ['\Legacy\Events\Iblock', 'onCheckPermissionBeforeUpdate']);
