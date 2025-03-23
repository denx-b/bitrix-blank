<?php

namespace Legacy\Agents;

class Common
{
    public static function yourAgentHere(): string
    {
        return '\\' . __CLASS__ . '::' . __FUNCTION__ . '();';
    }
}
