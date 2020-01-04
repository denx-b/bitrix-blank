<?php

$_SERVER['DOCUMENT_ROOT'] = __DIR__ .'/../../../..';
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

define('STOP_STATISTICS', true);
define('NO_KEEP_STATISTIC', true);
define('NOT_CHECK_PERMISSIONS', true);
define('BX_NO_ACCELERATOR_RESET', true);
define('PERFMON_STOP', true);

@set_time_limit(0);
@ignore_user_abort(true);

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';
