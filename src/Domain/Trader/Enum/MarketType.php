<?php

declare(strict_types=1);

namespace App\Domain\Trader\Enum;

enum MarketType: string
{
    case Stock = 'Фондовый';
    case Derivative = 'Срочный';
    case Exchange = 'Валютный';

    public function value(): int
    {
        return match ($this) {
            self::Stock => 1,
            self::Derivative => 2,
            self::Exchange => 3,
        };
    }
}
