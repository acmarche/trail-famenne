<?php

namespace App\Models;

use App\Constant\SexEnum;
use App\Constant\TshirtEnum;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Number;
use Illuminate\Support\Str;

class Walker extends Model
{
    use HasFactory;
    use HasUuids;

    protected $fillable = [
        'registration_id',
        'first_name',
        'last_name',
        'email',
        'street',
        'city',
        'country',
        'date_of_birth',
        'phone',
        'tshirt_size',
        'club_name',
        'display_name',
        'gdpr_accepted',
        'registration_date',
    ];

    protected function casts(): array
    {
        return [
            'tshirt_size' => TshirtEnum::class,
            'tshirt_sex' => SexEnum::class,
        ];
    }

    public function statusText(): string
    {
        return $this->isPaid() ? __('invoices::messages.invoice.paid') : __('invoices::messages.invoice.unpaid');
    }

    public function registrationDateFormated(): string
    {
        return Carbon::parse($this->registration_date)->translatedFormat('d F Y H:s');
    }

    public function communication(): string
    {
        return '100Km fact '.rand(1, 1000);//todo change it
    }

    public function runnersPaid(): array
    {
        return $this->all()
            ->filter->isPaid()
            //   ->filter->shipped()
            ->map->items
            ->collapse()
            ->groupBy->product_id
            ->map
            ->sum('price')
            ->filter(function ($total) {
                return $total > 1000;
            })
            ->sortDesc()
            ->take(10);
    }

    public function name(): string
    {
        return $this->first_name.' '.Str::upper($this->last_name);
    }

    public function amount(): float
    {
        if (!is_null($this->date_payment) && Carbon::parse($this->date_payment)->lt(Carbon::create(2025, 8, 1))) {
            return 45;
        }

        return 50;
    }

    public function isPaid(): bool
    {
        return $this->payement_date !== null;
    }

    public function amountInWords(): string
    {
        return Number::currency($this->amount(), in: 'EUR', locale: 'be');
    }

    public static function countAll(): int
    {
        return self::get()->count();
    }

    public static function registrationsUnpaidCount(): int
    {
        return self::whereNull('payment_date')->count();
    }

    public static function registrationsPaidCount(): int
    {
        return self::whereNotNull('payment_date')->count();
    }


}
