<?php

namespace App\Invoice;

use App\Models\Walker;

class Buyer
{
    public string $name;
    public string $email;
    public ?string $city = '';
    public ?string $address = '';
    public ?string $phone = '';

    public static function newFromWalker(Walker $walker): self
    {
        $buyer = new self();
        $buyer->email = $walker->email;
        $buyer->name = $walker->first_name.' '.$walker->last_name;
        $buyer->address = $walker->street;
        $buyer->city = $walker->city;
        $buyer->phone = $walker->phone;

        return $buyer;
    }

}
