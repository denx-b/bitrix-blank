<?php

require_once __DIR__ . '/_header.php';

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

Bitrix\Main\Config\Option::set('main', 'LAST_DB_OPTIMIZATION_TIME', time());
