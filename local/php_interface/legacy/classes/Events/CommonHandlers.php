<?php

namespace Legacy\Events;

use Bitrix\Main\UrlRewriter;

class CommonHandlers
{
    public static function initApi()
    {
        $found = false;
        $urlRewrite = UrlRewriter::getList(SITE_ID);
        foreach ($urlRewrite as $item) {
            if (str_contains($item['PATH'], '/local/php_interface/legacy/api.php')) {
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

    public static function endBufferContentHandler(&$content)
    {
        if (
            defined('LEGACY_MINIFY') && is_array(LEGACY_MINIFY) && in_array(SITE_ID, LEGACY_MINIFY) &&
            !str_contains($_SERVER['REQUEST_URI'], '/bitrix') &&
            !str_contains($_SERVER['REQUEST_URI'], '/local') &&
            !str_contains($_SERVER['REQUEST_URI'], '/rest') &&
            !str_contains($_SERVER['REQUEST_URI'], '/api') &&
            !str_contains($_SERVER['REQUEST_URI'], '/ajax') &&
            !preg_match('/.*\.(pdf|png|jpg|jpeg|gif|webp|exe)/i', $_SERVER['REQUEST_URI']) &&
            $GLOBALS['USER']->IsAdmin() !== true &&
            self::isAjax() === false
        ) {
            $content = self::removeCommentsFromMultilineScripts($content);
            $arReplace = ['/(\s)+/s' => '\\1'];
            $content = preg_replace(array_keys($arReplace), $arReplace, $content);
        }
    }

    protected static function removeCommentsFromMultilineScripts($content) {
        // Регулярное выражение для поиска многострочных <script>...</script>
        $pattern = '/(<script.[^>]+>)(.*?)[\n|\r]<\/script>/is';

        $callback = function($matches) {
            // Сохраняем открывающий тег с атрибутами
            $openingTag = $matches[1]; // Полный тег вместе с содержимым
            $scriptContent = $matches[2];

            // Самовызывающиеся функции с переносами строк или пробелами
            $scriptContent = preg_replace('/}\)\s+\(/', '})(', $scriptContent);
            // Закрыть строку точкой с запятой
            $scriptContent = preg_replace('/}\)([\r|\n])/', '});$1', $scriptContent);

            $scriptContent = preg_replace('/[\s\n\r]\/\/.*$/m', '', $scriptContent);
            //$scriptContent = preg_replace('/\/\*.*?\*\//s', '', $scriptContent);

            // Формируем новый тег <script> с очищенным содержимым
            return "{$openingTag}{$scriptContent}</script>";
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
}
