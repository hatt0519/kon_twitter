<?php

namespace Kon;

class Checker extends Api
{
    public static function is_ban($uri)
    {
        $ban = parent::convertJson($uri);
        return $ban->is_ban ?: false;
    }

    public static function is_holiday($uri)
    {
        $holiday = parent::convertJson($uri);
        return $holiday->is_holiday ?: false;
    }
}
