<?php

declare(strict_types=1);

namespace App\Domain\Common\Service;

use Symfony\Component\Uid\Ulid;

final class IdService
{
    public static function generate(): string
    {
        return Ulid::generate();
    }
}
