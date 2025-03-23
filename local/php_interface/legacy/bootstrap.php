<?php

/**
 * The ideology of the framework was developed by Legacy
 *
 * https://github.com/denx-b/bitrix-blank/tree/master
 * https://legacy-agency.ru/
 */

// autoloader PRS-4
require_once __DIR__ . '/autoload.php';

// constants
require_once __DIR__ . '/settings.php';

// composer
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once __DIR__ . '/vendor/autoload.php';
}

// functions or other files
foreach (glob(__DIR__ . '/functions/*.php') as $file) {
    require_once $file;
}

// events
foreach (glob(__DIR__ . '/eventHandlers/*.php') as $file) {
    require_once $file;
}
