<?php
/**
 * Вывод значения переменной любого типа (str|array) в консоль браузера
 * @param $debug_data
 */
function console_log($debug_data) {
    $js = is_array($debug_data) ? json_encode($debug_data) : '"'.$debug_data.'"' ;
    ?><script type="text/javascript">console.log(<?php echo $js?>)</script><?php
}

/**
 * print_r обёрнутая тегом pre
 * @param $debug_data
 */
function p($debug_data, $die = true) {
    $GLOBALS['APPLICATION']->RestartBuffer();
    if ($die === true && ob_get_contents()) {
        while (ob_get_contents()) {
            ob_end_clean();
        }
    }

    ?><pre><?print_r($debug_data)?></pre><?php

    if ($die === true) {
        die;
    }
}
