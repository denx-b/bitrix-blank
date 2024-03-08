<?php

namespace Legacy\Events;

class Iblock
{
    // Идентификатор ИБ новостей
    const IB_NEWS = 1;

    /**
     * Метод запрещает изменять элементы не авторам
     *
     * @param $arFields
     * @return bool
     */
    public static function onCheckPermissionBeforeUpdate(&$arFields): bool
    {
        // Выходим, если изменяет элемент не новостей
        if ($arFields['IBLOCK_ID'] != self::IB_NEWS) {
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
