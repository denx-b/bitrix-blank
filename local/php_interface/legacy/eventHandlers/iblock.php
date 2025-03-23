<?php

/**
 * Пример регистрации обработчиков события обновления элемента инфоблока
 */

/*
 * Метод запрещает изменять элементы не авторам.
 * Событие до изменения элемента информационного блока.
 */
AddEventHandler('iblock', 'OnBeforeIBlockElementUpdate', ['\Legacy\Events\IblockHandlers', 'onCheckPermissionBeforeUpdate']);
