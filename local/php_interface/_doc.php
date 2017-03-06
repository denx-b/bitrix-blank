<?
$this->__component->SetResultCacheKeys(array('SET_SPECIAL_DATE'));
$APPLICATION->SetPageProperty('specialdate', $arResult['SET_SPECIAL_DATE']);
?>
<meta property="specialdate" content="<?$APPLICATION->ShowProperty("specialdate")?>">


<?
$APPLICATION->ThrowException('Товар невозможно деактивировать');
CEventLog::Add(array(
	"SEVERITY" => "WARNING",	"AUDIT_TYPE_ID" => "MY_OWN_TYPE",
	"MODULE_ID" => "iblock",	"ITEM_ID" => (int) $arParams["ID"],
	"DESCRIPTION" => "Отмена деактивации"
));


AddEventHandler('main', 'OnBeforeEventAdd', 'OnBeforeEventFeedbackForm');
function OnBeforeEventFeedbackForm(&$event, &$lid, &$arFields) {}


$this->SetViewTarget("PRICES_BETWEEN");
echo $arResult['PRICES']['MIN'] .' - '. $arResult['PRICES']['MAX'];
$this->EndViewTarget();
echo $APPLICATION->ShowViewContent('PRICES_BETWEEN');


COption::GetOptionString($module_id, $name, $def="", $site=false, $bExactSite=false);
COption::SetOptionString($module_id, $name, $value="", $desc=false, $site="");
CEvent::Send($event, $lid, $arFields, $Duplicate = "Y", $message_id="", $files=array());


define('LOG_FILENAME', '/upload/log.txt');
AddMessage2Log('Возникла ошибка');


/**
 * http://dev.1c-bitrix.ru/api_help/main/general/constants.php
 *
 * SITE_ID                  Идентификатор текущего сайта.
 * SITE_DIR                 Поле "Папка сайта" в настройках сайта.
 * SITE_TEMPLATE_PATH       URL от корня сайта до папки текущего шаблона.
 * NEED_AUTH                Делает доступной стр. только для авторизованных
 * DBPersistent             Постоянное соединение с БД
 * LOG_FILENAME             Хранит абсолютный путь к log-файлу, используемого функцией AddMessage2Log
 * BX_DISABLE_INDEX_PAGE    Если true, то GetPagePath возвращает путь с "index.php", иначе - путь, заканч. на "/"
 *
 * $APPLICATION->SetPageProperty("NOT_SHOW_NAV_CHAIN", "Y"); - скрыть хлебные крошки
 *
 * BX.ajax.get('url', {}, callback);
 * ACTIVE = Y, ACTIVE_DATE = Y, CHECK_PERMISSIONS => Y
 */