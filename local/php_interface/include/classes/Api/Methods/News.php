<?php

namespace Legacy\Api\Methods;

use Legacy\Api\Api;

class News extends Api
{
    public function init()
    {
        $this->setField('news', [
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
        ]);
    }
}
