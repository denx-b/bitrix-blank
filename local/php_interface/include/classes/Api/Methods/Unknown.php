<?php

namespace Legacy\Api\Methods;

use Legacy\Api\Api;

class Unknown extends Api
{
    public function init()
    {
        $this->setResultError('Unknown method', 404);
    }
}
