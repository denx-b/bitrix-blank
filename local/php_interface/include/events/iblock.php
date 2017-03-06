<?
/** @global $eventManager */

/*
 * Вызывается до вставки элемента информационного блока
 * Может быть использовано для отмены вставки или переопределения некоторых полей.
 * https://dev.1c-bitrix.ru/api_help/iblock/events/onbeforeiblockelementadd.php
 */
$eventManager->addEventHandler('iblock', 'OnBeforeIBlockElementAdd', array('ConsultInfo_Iblock', 'deActiveBeforeAdd'));

class ConsultInfo_Iblock
{
    /**
     * При добавлении элемента не спецом, элемент будет неактивен
     *
     * @param $arParams
     */
    public function deActiveBeforeAdd(&$arParams)
    {
        global $USER;

        if (!in_array(GROUP_SPEC_ID, $USER->GetUserGroupArray()) && !$USER->IsAdmin()) {
            $arParams['ACTIVE'] = 'N';
        }
    }
}



