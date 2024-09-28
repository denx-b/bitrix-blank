<?php

namespace Legacy\Events;

use Bitrix\Main\UrlRewriter;

class MainHandlers
{
    public static function endBufferContentHandler(&$content)
    {
        if (
            defined('LEGACY_MINIFY') &&
            is_array(LEGACY_MINIFY) &&
            in_array(SITE_ID, LEGACY_MINIFY) &&
            strpos($_SERVER['REQUEST_URI'], '/bitrix') === false &&
            strpos($_SERVER['REQUEST_URI'], '/local') === false &&
            strpos($_SERVER['REQUEST_URI'], '/rest') === false &&
            strpos($_SERVER['REQUEST_URI'], '/api') === false &&
            !preg_match('/.*\.(pdf|png|jpg|jpeg|gif|webp|exe)/i', $_SERVER['REQUEST_URI']) &&
            $GLOBALS['APPLICATION']->PanelShowed !== true &&
            $GLOBALS['USER']->IsAdmin() !== true
        ) {
            $arReplace = ['/(\s)+/s' => '\\1'];
            $content = preg_replace(array_keys($arReplace), $arReplace, $content);
        }
    }

    public static function initApi()
    {
        $found = false;
        $urlRewrite = UrlRewriter::getList(SITE_ID);
        foreach ($urlRewrite as $item) {
            if (strpos($item['PATH'], '/local/php_interface/legacy/api.php') !== false) {
                $found = true;
            }
        }
        if ($found !== true) {
            UrlRewriter::add(SITE_ID, [
                'CONDITION' => '#^/+api/(.*)#',
                'RULE' => 'apiMethodName=$1',
                'PATH' => '/local/php_interface/legacy/api.php',
            ]);
        }
    }
}
