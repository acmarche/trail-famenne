<?php

namespace App\Utils;

use App\Models\Walker;

class RegistrationUtils
{
    public static function lastRegistrationId(): int
    {
        return Walker::max('registration_id');
    }
}
