<?php

namespace Dbogdanoff\Api\Methods;

use Dbogdanoff\Api\Api;

class Unknown extends Api
{
    public function init()
    {
        $this->responseCode = 404;
        $this->setResultError('unknown method', 404);
    }
}
