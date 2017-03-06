<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

COption::SetOptionString("main", "agents_use_crontab", "N");
echo COption::GetOptionString("main", "agents_use_crontab", "N");

COption::SetOptionString("main", "check_agents", "N");
echo COption::GetOptionString("main", "check_agents", "Y");

/*
 * Чтобы не увеличивалась очередь отправки почтовых сообщений, нужно изменить параметр,
 * отвечающий за количество почтовых обрабатываемых за раз событий.
 * Для этого выполняем в php-консоли следующую команду:
 *
 * COption::SetOptionString("main", "mail_event_bulk", "20");
 * echo COption::GetOptionString("main", "mail_event_bulk", "5");
 */