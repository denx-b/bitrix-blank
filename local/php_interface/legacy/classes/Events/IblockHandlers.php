<?php

namespace Legacy\Events;

class IblockHandlers
{
    /**
     * Метод запрещает изменять элементы не авторам
     *
     * @param $arFields
     * @return bool
     */
    public static function onCheckPermissionBeforeUpdate(&$arFields): bool
    {
        // Выходим, если изменяет элемент не новостей
        if ($arFields['IBLOCK_ID'] != \Legacy\Const\News::IBLOCK_ID) {
            return true;
        }

        global $APPLICATION, $USER;

        $rsElement = \CIBlockElement::GetByID($arFields['ID']);
        $arElement = $rsElement->Fetch();

        if ($arFields['MODIFIED_BY'] != $arElement['CREATED_BY'] && $USER->IsAdmin() !== true) {
            $APPLICATION->ThrowException('Этот элемент может изменять только его создатель.');
            return false;
        }

        return true;
    }
}
