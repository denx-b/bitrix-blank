<?php

namespace Legacy\Rest;

class Test extends \IRestService
{
    public static function init(): array
    {
        return array(
            \CRestUtil::GLOBAL_SCOPE => [
                'legacy.test' => [
                    'callback' => [__CLASS__, 'rest'],
                    'options' => [],
                ],
            ]
        );
    }

    public static function rest($query, $n, \CRestServer $server): array
    {
        return [
            'message' => 'Hello world',
        ];
    }
}
