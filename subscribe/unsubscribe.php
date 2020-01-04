<?php

/**
 * Скрипт на который переходят пользователи, чтобы отписаться от рассылки
 */

use Bitrix\Main\Application;
use Dbogdanoff\Model\SubscriptionTable;
use Dbogdanoff\Events\Subscribe;

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

try {
    $request = Application::getInstance()->getContext()->getRequest();
    $email = $request->get('email');
    $hash = $request->get('hash');

    // Проверка хеша
    if ($hash != Subscribe::getHash($email)) {
        throw new Exception('Invalid hash.');
    }

    // Поиск подписчика по E-mail
    $db = SubscriptionTable::getList([
        'filter' => ['EMAIL' => $email, 'ACTIVE' => 'Y'],
        'select' => ['ID']
    ]);

    // Деактивация подписки
    while ($row = $db->fetch()) {
        SubscriptionTable::update($row['ID'], [
            'ACTIVE' => 'N',
            'DATE_UPDATE' => new \Bitrix\Main\Type\DateTime()
        ]);
    }

    echo 'You have successfully unsubscribed.';
} catch (Exception $e) {
    echo $e->getMessage();
}
