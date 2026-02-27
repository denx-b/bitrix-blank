<?php

if (!defined('NO_KEEP_STATISTIC')) {
    define('NO_KEEP_STATISTIC', true);
}
if (!defined('NO_AGENT_STATISTIC')) {
    define('NO_AGENT_STATISTIC', true);
}
if (!defined('NO_AGENT_CHECK')) {
    define('NO_AGENT_CHECK', true);
}
if (!defined('DisableEventsCheck')) {
    define('DisableEventsCheck', true);
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

$request = Bitrix\Main\Application::getInstance()->getContext()->getRequest();

$methodSuffix = preg_replace('/\/+/', '/', (string)$request->get('apiMethodName'));
$methodSuffix = explode('?', $methodSuffix)[0];
$methodSuffix = trim($methodSuffix, '/');

$method = '/api' . ($methodSuffix !== '' ? '/' . $methodSuffix : '');

$api = Legacy\Api\ApiFactory::create($method);
$api->result();
