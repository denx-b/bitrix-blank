<?php

namespace Dbogdanoff\Api;

use Dbogdanoff\Api\Methods;

class ApiFactory implements ApiFactoryInterface
{
    public static function create(string $method = ''): Api
    {
        try {
            switch ($method) {
                case 'news':
                    $api = new Methods\News();
                    break;

                default:
                    $api = new Methods\Unknown();
            }

            $api->init();

        } catch (\Exception $e) {
            $api = new Methods\Unknown();
            $api->setResultError($e->getMessage());
        }

        return $api;
    }
}
