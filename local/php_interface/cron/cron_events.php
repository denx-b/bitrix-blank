<?php

require_once __DIR__ . '/_header.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';

CAgent::CheckAgents();

const BX_CRONTAB_SUPPORT = true;
const BX_CRONTAB = true;

if (CModule::IncludeModule('sender')) {
    Bitrix\Sender\MailingManager::checkPeriod(false);
    Bitrix\Sender\MailingManager::checkSend();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/tools/backup.php';

CMain::FinalActions();
