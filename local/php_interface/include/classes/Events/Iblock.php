<?php

namespace Dbogdanoff\Events;

class Iblock
{
    public static function beforeIBlockElementUpdateHandler(&$arFields)
    {
        // Новости могут изменять только авторы или админы
        if ($arFields['IBLOCK_ID'] == IBLOCK_ID_NEWS) {
            self::checkPermissionBeforeUpdate($arFields);
        }

        // Застявляет указывать символьный код в каталоге
        if ($arFields['IBLOCK_ID'] == IBLOCK_ID_CATALOG) {
            self::checkCodeBeforeUpdate($arFields);
        }
    }

    /**
     * Метод запрещает изменять элементы не авторам
     *
     * @param $arFields
     * @return bool
     */
    public static function checkPermissionBeforeUpdate(&$arFields)
    {
        global $APPLICATION, $USER;

        $rsElement = \CIBlockElement::GetByID($arFields['ID']);
        $arElement = $rsElement->Fetch();

        if ($arFields['MODIFIED_BY'] != $arElement['CREATED_BY'] && $USER->IsAdmin() !== true) {
            $APPLICATION->ThrowException('Этот элемент может изменять только его создатель.');
            return false;
        }

        return true;
    }

    /**
     * Метод проверяет наличие символьного кода у элемента
     *
     * @param $arFields
     * @return bool
     */
    public static function checkCodeBeforeUpdate(&$arFields)
    {
        global $APPLICATION;

        if (strlen($arFields["CODE"]) <= 0) {
            $APPLICATION->throwException("Введите символьный код. (ID:" . $arFields["ID"] . ")");
            return false;
        }

        return true;
    }
}
