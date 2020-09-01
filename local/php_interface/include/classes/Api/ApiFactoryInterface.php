<?php

namespace Dbogdanoff\Api;

interface ApiFactoryInterface
{
    public static function create(): Api;
}
