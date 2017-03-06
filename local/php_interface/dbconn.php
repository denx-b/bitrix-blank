<?
// Агенты на кроне
if(!(defined("CHK_EVENT") && CHK_EVENT===true))
    define("BX_CRONTAB_SUPPORT", true);

// Настройка логирования php-ошибок
error_reporting(E_ERROR | E_WARNING | E_PARSE);
ini_set("display_errors", "0");
ini_set('error_log', "/home/bitrix/www/upload/php-exception-log-txt");

// Увеличение ограничения памяти на php-скрипты
ini_set('memory_limit', '2048M');

// Установка ограничения времени исполнения php-скрипта
@set_time_limit(0);

// Игнорировать разрыв терминала. Скрипт ДОЛЖЕН выполняться даже после закрытия ssh-терминала
@ignore_user_abort(true);