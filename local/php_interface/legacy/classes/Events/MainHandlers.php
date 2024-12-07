<?php

namespace Legacy\Events;

use Bitrix\Main\UrlRewriter;

class MainHandlers
{
    public static function endBufferContentHandler(&$content)
    {
        if (
            defined('LEGACY_MINIFY') && is_array(LEGACY_MINIFY) && in_array(SITE_ID, LEGACY_MINIFY) &&
            strpos($_SERVER['REQUEST_URI'], '/bitrix') === false &&
            strpos($_SERVER['REQUEST_URI'], '/local') === false &&
            strpos($_SERVER['REQUEST_URI'], '/rest') === false &&
            strpos($_SERVER['REQUEST_URI'], '/api') === false &&
            strpos($_SERVER['REQUEST_URI'], '/ajax') === false &&
            !preg_match('/.*\.(pdf|png|jpg|jpeg|gif|webp|exe)/i', $_SERVER['REQUEST_URI']) &&
            $GLOBALS['USER']->IsAdmin() !== true &&
            self::isAjax() === false
        ) {
            $content = self::removeCommentsFromMultilineScripts($content);
            $arReplace = ['/(\s)+/s' => '\\1'];
            $content = preg_replace(array_keys($arReplace), $arReplace, $content);
        }
    }

    protected static function removeCommentsFromMultilineScripts($content)
    {
        // Регулярное выражение для поиска многострочных <script>...</script>
        $pattern = '/<script>(.*?)<\/script>/is';
        $callback = function($matches) {
            $scriptContent = $matches[1];
            $scriptContent = preg_replace('/^\s*\/\/.*$/m', '', $scriptContent); // Удаление строк, начинающихся с //
            return "<script>{$scriptContent}</script>";
        };
        return preg_replace_callback($pattern, $callback, $content);
    }

    protected static function isAjax(): bool
    {
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest') {
            return true;
        } else {
            return false;
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
