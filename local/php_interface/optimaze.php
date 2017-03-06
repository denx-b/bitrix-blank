<?php
$_SERVER["DOCUMENT_ROOT"] = '/home/bitrix/www';
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

set_time_limit(0);
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
error_reporting(E_ERROR | E_WARNING | E_PARSE);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

@mb_http_output('utf-8');
@mb_internal_encoding('utf-8');
@mb_regex_encoding('utf-8');

$DBDebug = true;

function optimaze($filter)
{
    global $DB;
    $res = $DB->Query("SHOW TABLES LIKE '$filter%'");
    if ($row = $res->Fetch())
    {
        $keys = array_keys($row);
        $col = $keys[0];
        do
        {
            $tbl = $row[$col];
            $DB->Query("CHECK TABLE `$tbl`");
            $DB->Query("OPTIMIZE TABLE `$tbl`");
        } while($row = $res->Fetch());
    }
}

optimaze("b_");