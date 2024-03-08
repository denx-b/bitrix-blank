<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

$request = Bitrix\Main\Application::getInstance()->getContext()->getRequest();

$method = preg_replace('/\/+/', '/', $request->get('apiMethodName'));
$method = explode('?', $method)[0];
$method = trim($method, '/');

$api = Legacy\Api\ApiFactory::create($method);
$api->result();
