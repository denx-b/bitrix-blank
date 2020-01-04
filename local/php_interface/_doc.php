<?php

/**
 * Как вывести произвольный контент в шаблоне сайта и компонента
 * https://dev.1c-bitrix.ru/learning/course/index.php?COURSE_ID=43&LESSON_ID=3855
 */
$this->SetViewTarget('PRICES_BETWEEN');
echo $arResult['PRICES']['MIN'] .' - '. $arResult['PRICES']['MAX'];
$this->EndViewTarget();
echo $APPLICATION->ShowViewContent('PRICES_BETWEEN');


/**
 * Агенты на cron
 */
COption::SetOptionString('main', 'agents_use_crontab', 'N');
echo COption::GetOptionString('main', 'agents_use_crontab', 'N');

COption::SetOptionString('main', 'check_agents', 'N');
echo COption::GetOptionString('main', 'check_agents', 'Y');

/*
 * Чтобы не увеличивалась очередь отправки почтовых сообщений, нужно изменить параметр,
 * отвечающий за количество почтовых обрабатываемых за раз событий.
 * Для этого выполняем в php-консоли следующую команду:
 *
 * COption::SetOptionString('main', 'mail_event_bulk', '20');
 * echo COption::GetOptionString('main', 'mail_event_bulk', '5');
 */


/**
 * Логирование в файл
 */
define('LOG_FILENAME', '/upload/log.txt');
AddMessage2Log('Возникла ошибка');


/**
 * Специальные константы
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
 * $APPLICATION->SetPageProperty('NOT_SHOW_NAV_CHAIN', 'Y'); - скрыть хлебные крошки
 */


/**
 * Передача данных из arResult кешированного компонента в component_epilog.php
 * Под капотом битрикс сериализирует данные https://dev.1c-bitrix.ru/community/webdev/user/11948/blog/5500/
 */
$this->__component->SetResultCacheKeys(['SET_SPECIAL_DATE']);
$APPLICATION->SetPageProperty('specialdate', $arResult['SET_SPECIAL_DATE']);
\Bitrix\Main\Page\Asset::getInstance()->addString();
?>
<meta property="specialdate" content="<?php$APPLICATION->ShowProperty('specialdate')?>">

