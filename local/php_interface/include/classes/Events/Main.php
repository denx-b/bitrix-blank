<?php

namespace Dbogdanoff\Events;

use Bitrix\Main\Application;
use Dbogdanoff\Api\ApiFactory;

class Main
{
    public static function endBufferContentHandler(&$content)
    {
        if (
            defined('LEGANCY_MINIFY') &&
            strpos($_SERVER['REQUEST_URI'], '/bitrix') === false &&
            strpos($_SERVER['REQUEST_URI'], '/local') === false &&
            strpos($_SERVER['REQUEST_URI'], '/rest') === false &&
            strpos($_SERVER['REQUEST_URI'], '/api') === false &&
            !preg_match('/.*\.(pdf|png|jpg|jpeg|gif|webp|exe)/i', $_SERVER['REQUEST_URI']) &&
            $GLOBALS['APPLICATION']->PanelShowed !== true &&
            $GLOBALS['USER']->IsAdmin() !== true
        ) {
            $arReplace = ['/(\s)+/s' => '\\1'];

            if (LEGANCY_MINIFY === 'hard') {
                $arReplace['/\>[^\S ]+/s'] = '>';
                $arReplace['/[^\S ]+\</s'] = ' <';
            }

            $content = preg_replace(array_keys($arReplace), $arReplace, $content);
        }
    }

    public static function initApi()
    {
        $request = Application::getInstance()->getContext()->getRequest();
        $server = Application::getInstance()->getContext()->getServer();

        $basePath = '/api';
        $regex = '/' . str_replace('/', '\/', $basePath) . '\/?/';

        if (strpos($request->getRequestUri(), $basePath) === 0) {
            $method = preg_replace($regex, '', $server->get('SCRIPT_URL'));
            $api = ApiFactory::create($method);
            $api->result();
        }
    }
}
