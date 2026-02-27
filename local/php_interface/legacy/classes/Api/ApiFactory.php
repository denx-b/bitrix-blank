<?php

namespace Legacy\Api;

use Exception;
use Legacy\Api\Methods;

class ApiFactory
{
    public static function create(string $method = ''): Api
    {
        try {
            self::isValidMethodName($method);

            $map = ApiRoutes::map();
            $apiClass = $map[$method] ?? Methods\Unknown::class;
            $api = new $apiClass();

            $api->init();
        } catch (Exception $e) {
            $api = new Methods\Unknown();
            $api->setResultError($e->getMessage());
        }

        return $api;
    }

    /**
     * @throws Exception
     */
    private static function isValidMethodName(string $method)
    {
        if (preg_match('/^[A-Za-z0-9_\/-]+$/', $method) !== 1) {
            throw new Exception('Invalid method format');
        }
    }
}
