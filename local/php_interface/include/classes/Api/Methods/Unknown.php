<?php

namespace Legacy\Api\Methods;

use Legacy\Api\Api;

class Unknown extends Api
{
    public function init()
    {
        $this->responseCode = 404;
        $this->setResultError('unknown method', 404);
    }
}
