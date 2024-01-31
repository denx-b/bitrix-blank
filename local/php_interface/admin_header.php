<?php

/**
 * Данный файл автоматом подключается в админке и можно добавить свои скрипти, например.
 */

/** @global CMain $APPLICATION */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

// Следующий пример подключает jQuery, файл стилей и скриптов на странице списка ИБ с ID IBLOCK_ID_NEWS
if (
    $GLOBALS['APPLICATION']->GetCurPage(true) == '/bitrix/admin/iblock_list_admin.php' &&
    $_REQUEST['IBLOCK_ID'] == IBLOCK_ID_NEWS
) {
    CJSCore::Init('jquery');
    Bitrix\Main\Page\Asset::getInstance()->addJs('');
    $APPLICATION->SetAdditionalCSS('');
}
