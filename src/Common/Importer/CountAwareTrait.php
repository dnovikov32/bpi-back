<?php

declare(strict_types=1);

namespace App\Common\Importer;

trait CountAwareTrait
{
    private int $count = 0;

    public function count(): int
    {
        return $this->count;
    }
}
