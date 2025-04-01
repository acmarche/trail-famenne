<?php

namespace App\Constant;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum SexEnum: string implements HasLabel, HasColor, HasIcon
{
    case WOMAN = 'WOMAN';
    case MAN = 'MAN';

    public function getLabel(): ?string
    {
        return match ($this) {
            self::WOMAN => __(self::WOMAN->value),
            self::MAN => __(self::MAN->value),
        };
    }

    public function getIconColor(): string
    {
        return match ($this) {
            self::WOMAN => 'gray',
            default => 'success',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::WOMAN => 'gray',
            default => 'success',
        };
    }

    public function getIcon(): ?string
    {
        return match ($this) {
            self::WOMAN => 'tabler-woman',
            default => 'tabler-man',
        };
    }
}
