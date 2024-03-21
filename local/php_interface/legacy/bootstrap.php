<?php

/**
 * The ideology of the framework was developed by Legacy
 *
 * https://github.com/denx-b/bitrix-blank/tree/master
 * https://legacy-agency.ru/
 */

// autoloader
require_once __DIR__ . '/autoload.php';

// constants
require_once __DIR__ . '/settings.php';

// composer
//require_once __DIR__ . '/vendor/autoload.php';

// events
foreach (glob(__DIR__ . '/eventHandlers/*.php') as $file) {
    require_once $file;
}
