<?php

namespace App\Services;

class Price
{
    public static function price($number): float
    {
        return (float)number_format($number, 2, '.', '');
    }
}
