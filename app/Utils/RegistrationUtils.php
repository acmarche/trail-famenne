<?php

namespace App\Utils;

use App\Models\Walker;
use Illuminate\Database\Eloquent\Model;

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

    public static function generateNumber(Walker|Model $currentWalker): void
    {
        // Get the maximum 'tshirt_number' from the 'walkers' table
        $lastTshirtNumber = Walker::max('tshirt_number');

        // If no t-shirt numbers have been assigned yet, start from 1
        if (is_null($lastTshirtNumber)) {
            $currentWalker->tshirt_number = 1;
        } else {
            $currentWalker->tshirt_number = $lastTshirtNumber + 1;
        }
    }
}
