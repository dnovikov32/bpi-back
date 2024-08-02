<?php

declare(strict_types=1);

namespace App\Domain\Trader\Enum;

use InvalidArgumentException;

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

    public static function fromValue(int $value): self
    {
        foreach (self::cases() as $case) {
            if ($case->value() === $value) {
                return $case;
            }
        }

        throw new InvalidArgumentException(sprintf('Enum does not exist for value %d', $value));
    }
}
