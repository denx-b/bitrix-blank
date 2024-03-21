<?php

namespace Legacy\Events;

use Bitrix\Crm\Service\Container;
use Bitrix\Main\Entity;
use Bitrix\Main\Entity\Event;
use Exception;

class CrmDynamic
{
    // Идентификатор смарт-процесса в Б24
    const LEGACY_DYNAMIC_TYPE_SHOPS = 108;

    /**
     * Обработчик события обновления/добавления элемента смарт-процесса
     *
     * @param Event $event
     * @return Entity\EventResult
     * @throws Exception
     */
    public static function onUpdateOrAdd(Event $event): Entity\EventResult
    {
        $result = new Entity\EventResult();

        // Все данные текущего элемента смарт процесса
        $arData = self::getAllData($event);

        /*
         * Тут код нашего обработчика
         */

        return $result;
    }

    /**
     * Возвращает массив всех полей элемента смарта, в т.ч. и UF_*
     *
     * @param Event $event
     * @return array
     */
    protected static function getAllData(Event $event): array
    {
        $elementId = $event->getParameter('id');
        if (is_array($elementId)) {
            $elementId = $elementId['ID'];
        }

        // Получаем данные элемента
        $factoryDynamic = Container::getInstance()->getFactory(self::LEGACY_DYNAMIC_TYPE_SHOPS);
        return $factoryDynamic->getItem($elementId)->getData();
    }
}
