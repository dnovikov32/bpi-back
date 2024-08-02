<?php

declare(strict_types=1);

namespace App\Console\Trader\Trader\Import;

use App\Common\Importer\ImportOptionsInterface;
use App\Console\Common\BaseImportFromApiWithProgressbar;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

final class Command extends BaseImportFromApiWithProgressbar implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    protected function configure(): void
    {
        $this->addArgument(
            'year',
            InputArgument::REQUIRED,
            'Year',
        );
    }

    protected function getImportOptions(InputInterface $input): ImportOptionsInterface
    {
        return new Options(
            year: (int) $input->getArgument('year')
        );
    }
}
