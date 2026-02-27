<?php

namespace Legacy\Api;

use Legacy\Api\Methods;

final class ApiRoutes
{
    /**
     * @return array<string, class-string<Api>>
     */
    public static function map(): array
    {
        return [
            '/api/news' => Methods\News::class,
            '/api/deploy/gitStatus' => Methods\Deploy\GitStatus::class,
        ];
    }
}
