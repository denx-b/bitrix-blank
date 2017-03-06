<?
$eventManager = \Bitrix\Main\EventManager::getInstance();

// Подключить вспомогательные функции
include('include/settings.php');

// Подключить вспомогательные функции
include('include/functions.php');

// Подключить обработчики событий модуля инфоблоков
include('include/events/iblock.php');

// Подключить обработчики событий главного модуля
include('include/events/main.php');

// Подключить обработчики событий модуля sale
include('include/events/sale.php');