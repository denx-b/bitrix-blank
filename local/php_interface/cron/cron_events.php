<?php

require_once __DIR__ . '/_header.php';

global $DB;
$DB->Query('SELECT 1');

CAgent::CheckAgents();

const BX_CRONTAB_SUPPORT = true;
const BX_CRONTAB = true;

if (CModule::IncludeModule('sender')) {
    Bitrix\Sender\MailingManager::checkPeriod(false);
    Bitrix\Sender\MailingManager::checkSend();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/tools/backup.php';

CMain::FinalActions();
