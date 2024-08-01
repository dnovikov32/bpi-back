<?php

declare(strict_types=1);

namespace App\Console\Instrument\Share\Import;

use App\Common\Importer\ImportOptionsInterface;
use App\Console\Common\BaseImportFromApiWithProgressbar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Tinkoff\Invest\V1\InstrumentStatus;

final class Command extends BaseImportFromApiWithProgressbar
{
    protected function configure(): void
    {
        $this->addArgument(
            'instrumentStatus',
            InputArgument::OPTIONAL,
            'Status of requested instruments (default: all instruments)',
            InstrumentStatus::INSTRUMENT_STATUS_ALL
        );
    }

    protected function getImportOptions(InputInterface $input): ImportOptionsInterface
    {
        return new Options(
            instrumentStatus: (int) $input->getArgument('instrumentStatus'),
        );
    }
}
