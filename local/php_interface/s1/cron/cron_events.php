<?php

require_once __DIR__ . '/_header.php';

CAgent::CheckAgents();
define('BX_CRONTAB_SUPPORT', true);
define('BX_CRONTAB', true);
CEvent::CheckEvents();

if (CModule::IncludeModule('subscribe'))
{
    $cPosting = new CPosting;
    $cPosting->AutoSend();
}
