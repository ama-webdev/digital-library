<?php

namespace App\Helper;

use Illuminate\Support\Str;

class UUID
{
    static function generate()
    {
        $uuid = substr((string) Str::uuid(), 0, 8);
        return $uuid;
    }
}