<?php

namespace App\Utils;

use App\Models\Walker;

class RegistrationUtils
{
    public static function lastRegistrationId(): int
    {
        $id = Walker::max('registration_id');
        if (!$id) {//first
            return 1;
        }

        return $id;
    }
}
