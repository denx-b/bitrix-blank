<?php

$_SERVER['DOCUMENT_ROOT'] = __DIR__ .'/../../..';
$DOCUMENT_ROOT = $_SERVER['DOCUMENT_ROOT'];

const STOP_STATISTICS = true;
const NO_KEEP_STATISTIC = true;
const NOT_CHECK_PERMISSIONS = true;
const BX_NO_ACCELERATOR_RESET = true;
const PERFMON_STOP = true;
const CHK_EVENT = true;
const BX_WITH_ON_AFTER_EPILOG = true;

@set_time_limit(0);
@ignore_user_abort(true);

require $_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/prolog_before.php';
