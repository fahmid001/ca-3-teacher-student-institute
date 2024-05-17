<?php

namespace App\Helper;

enum ClassEnum:int
{
    case Six = 6;
    case Seven = 7;

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}
