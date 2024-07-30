<?php

declare(strict_types=1);

namespace App\Common\Importer;

use Countable;
use Generator;

interface IterableImporterInterface extends Countable
{
    public function import(ImportOptionsInterface $options): Generator;

    public function count(): int;
}
