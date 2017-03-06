<?
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
        if (!in_array(GROUP_ID_CONTENT, $USER->GetUserGroupArray())) {
            $arParams['ACTIVE'] = 'N';
        }
    }
}



