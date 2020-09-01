<?php

namespace Dbogdanoff\Api\Methods;

use Dbogdanoff\Api\Api;

class News extends Api
{
    public function init()
    {
        $this->result = [
            [
                'id' => 1,
                'name' => 'Название новости 1',
                'text' => 'Текст новости 1'
            ],
            [
                'id' => 2,
                'name' => 'Название новости 2',
                'text' => 'Текст новости 2'
            ],
        ];
    }
}
