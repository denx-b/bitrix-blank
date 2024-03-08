<?php

use Bitrix\Crm\Service\Container;
use Bitrix\Main\Loader;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\EventManager;
use Legacy\Events\CrmDynamic;

/**
 * В данном файле приведён пример регистрации обработчиков события добавления и обновления смарт-процессов
 */

if (!Loader::includeModule('crm')) {
    return;
}

$eventManager = EventManager::getInstance();

$factoryDynamic = Container::getInstance()->getFactory(CrmDynamic::LEGACY_DYNAMIC_TYPE_SHOPS);
$classNameTypeShops = $factoryDynamic->getDataClass();

/*
 * Событие после добавления элемента смарт-процесса
 */
$eventManager->addEventHandler($classNameTypeShops, DataManager::EVENT_ON_AFTER_ADD,
    ['\Legacy\Events\CrmDynamic', 'onUpdateOrAdd']
);

/*
 * Событие после обновления элемента смарт-процесса
 */
$eventManager->addEventHandler($classNameTypeShops, DataManager::EVENT_ON_AFTER_UPDATE,
    ['\Legacy\Events\CrmDynamic', 'onUpdateOrAdd']
);
