<?php

namespace Legacy\Api;

use Legacy\Api\Methods;

class ApiFactory implements ApiFactoryInterface
{
    public static function create(string $method = ''): Api
    {
        try {
            $api = match ($method) {
                'news' => new Methods\News(),
                'deploy/gitStatus' => new Methods\Deploy\GitStatus(),

                default => new Methods\Unknown(),
            };

            $api->init();

        } catch (\Exception $e) {
            $api = new Methods\Unknown();
            $api->setResultError($e->getMessage());
        }

        return $api;
    }
}
