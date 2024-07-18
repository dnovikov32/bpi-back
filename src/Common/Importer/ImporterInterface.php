<?php

declare(strict_types=1);

namespace App\Common\Importer;

interface ImporterInterface
{
    public function import(ImportOptionsInterface $options): void;
}
