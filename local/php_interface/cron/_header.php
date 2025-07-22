<?php

$_SERVER['DOCUMENT_ROOT'] = __DIR__ .'/../../..';
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

const NO_KEEP_STATISTIC = true;
const NOT_CHECK_PERMISSIONS = true;
const BX_NO_ACCELERATOR_RESET = true;
const CHK_EVENT = true;
const BX_WITH_ON_AFTER_EPILOG = true;

@set_time_limit(0);
@ignore_user_abort(true);

ini_set('memory_limit', '512M');
ini_set('max_execution_time', 600);
ini_set('default_socket_timeout', 600);

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';
