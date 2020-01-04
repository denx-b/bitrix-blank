<?php

/**
 * Данный файл подключается в админке и можно добавить свои скрипти, например.
 */

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) {
    die();
}

use Bitrix\Main\Page\Asset;

/**
 * Список элементов какого-нибудь инфоблока
 * Подобным образом можно внедриться вообще куда угодно в админке
 */
if (
    $GLOBALS['APPLICATION']->GetCurPage(true) == '/bitrix/admin/iblock_list_admin.php' &&
    $_REQUEST['IBLOCK_ID'] == IBLOCK_ID_NEWS
) {
    CJSCore::Init('jquery');
    Asset::getInstance()->addJs('');
    $APPLICATION->SetAdditionalCSS('');
}
