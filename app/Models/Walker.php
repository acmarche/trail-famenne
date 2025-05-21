<?php

namespace App\Models;

use App\Constant\SexEnum;
use App\Constant\TshirtEnum;
use Illuminate\Database\Eloquent\Builder;
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
        'tshirt_sex',
        'club_name',
        'display_accepted',
        'newsletter_accepted',
        'gdpr_accepted',
        'regulation_accepted',
        'payment_date',
        'registration_date',
    ];

    protected function casts(): array
    {
        return [
            'tshirt_size' => TshirtEnum::class,
            'tshirt_sex' => SexEnum::class,
            'payment_date' => 'datetime',
            'display_accepted'=>'bool',
            'newsletter_accepted'=>'bool',
            'gdpr_accepted'=>'bool',
            'regulation_accepted'=>'bool'
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
        return '100Km num '.$this->registration_id;
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
        $today = Carbon::today();
        if ($today < Carbon::create(2025, 8, 1)) {
            return 45;
        }

        return 50;
    }

    public function isPaid(): bool
    {
        return $this->payment_date !== null;
    }

    public function amountInWords(): string
    {
        return Number::currency($this->amount(), in: 'EUR', locale: 'be');
    }

    public function age(): float
    {
        return round(Carbon::parse($this->date_of_birth)->diffInYears(Carbon::now()));
    }

    public static function countAll(): int
    {
        return self::get()->count();
    }

    public static function unpaidCount(): int
    {
        return self::whereNull('payment_date')->count();
    }

    public static function paidCount(): int
    {
        return self::whereNotNull('payment_date')->count();
    }

    public static function canHaveTshirts(): Builder
    {
        return self::query()
            ->where('payment_date', '<', Carbon::parse(config('invoices.TRAIL_TSHIRT_ENDDATE')))
            ->orderBy('last_name', 'asc')
            ->orderBy('first_name', 'asc');
    }


}
