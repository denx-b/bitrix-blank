<?php

namespace Legacy\Api;

interface ApiFactoryInterface
{
    public static function create(): Api;
}
