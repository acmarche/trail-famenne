<?php


return [
    'MAIL_IT_ADDRESS' => env('MAIL_IT_ADDRESS'),
    'TRAIL_TSHIRT_ENDDATE' => env('TRAIL_TSHIRT_ENDDATE'),
    'seller' =>
        [
            'name' => env('APP_NAME'),
            'address' => env('TRAIL_ADDRESS'),
            'code' => env('TRAIL_CODE'),
            'city' => env('TRAIL_CITY'),
            'phone' => env('TRAIL_PHONE'),
            'email' => env('TRAIL_EMAIL'),
            'bank_account' => env('TRAIL_BANK_ACCOUNT'),
            /*
             * Class used in templates via $invoice->seller
             *
             * Must implement LaravelDaily\Invoices\Contracts\PartyContract
             *      or extend LaravelDaily\Invoices\Classes\Party
             */
        ],

    'date' => [

        /*
         * Carbon date format
         */
        'format' => 'Y-m-d',

        /*
         * Due date for payment since invoice's date.
         */
        'pay_until_days' => 7,
    ],

    'serial_number' => [
        'series' => 'AA',
        'sequence' => 1,

        /*
         * Sequence will be padded accordingly, for ex. 00001
         */
        'sequence_padding' => 5,
        'delimiter' => '.',

        /*
         * Supported tags {SERIES}, {DELIMITER}, {SEQUENCE}
         * Example: AA.00001
         */
        'format' => '{SERIES}{DELIMITER}{SEQUENCE}',
    ],

    'currency' => [
        'code' => 'eur',

        /*
         * Usually cents
         * Used when spelling out the amount and if your currency has decimals.
         *
         * Example: Amount in words: Eight hundred fifty thousand sixty-eight EUR and fifteen ct.
         */
        'fraction' => 'ct.',
        'symbol' => '€',

        /*
         * Example: 19.00
         */
        'decimals' => 2,

        /*
         * Example: 1.99
         */
        'decimal_point' => ',',

        /*
         * By default empty.
         * Example: 1,999.00
         */
        'thousands_separator' => '',

        /*
         * Supported tags {VALUE}, {SYMBOL}, {CODE}
         * Example: 1.99 €
         */
        'format' => '{VALUE} {SYMBOL}',
    ],

    'paper' => [
        // A4 = 210 mm x 297 mm = 595 pt x 842 pt
        'size' => 'a4',
        'orientation' => 'portrait',
    ],

    'disk' => 'local',

    'dompdf_options' => [
        'enable_php' => true,
        'enable_remote' => true,
        /**
         * Do not write log.html or make it optional
         * @see https://github.com/dompdf/dompdf/issues/2810
         */
        'logOutputFile' => '/dev/null',
    ],
];
