<?php

namespace App\Constant;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum TshirtEnum: string implements HasLabel, HasColor, HasIcon
{
    case NO = 'NONE';
    case XS = 'XS';
    case S = 'S';
    case M = 'M';
    case L = 'L';
    case XL = 'XL';
    case XXL = 'XXL';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::NO => __(self::NO->value),
            self::XS => self::XS->value,
            self::S => self::S->value,
            self::M => self::M->value,
            self::L => self::L->value,
            self::XL => self::XL->value,
            self::XXL => self::XXL->value,
        };
    }

    public function getIconColor(): string
    {
        return match ($this) {
            self::NO => 'gray',
            default => 'success',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::NO => 'gray',
            default => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::NO => 'tabler-shirt-off',
            default => 'tabler-shirt',
        };
    }
}
