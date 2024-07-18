<?php

declare(strict_types=1);

namespace App\Console\Share\Import;

use App\Common\Importer\ImportOptionsInterface;
use App\Console\BaseImportFromApi;
use Symfony\Component\Console\Input\InputInterface;
use Tinkoff\Invest\V1\InstrumentStatus;

final class Command extends BaseImportFromApi
{
    protected function configure(): void
    {
        $this->setDescription('Получение списка всех акций');
    }

    protected function getImportParameters(InputInterface $input): ImportOptionsInterface
    {
        return new Options(InstrumentStatus::INSTRUMENT_STATUS_ALL);
    }
}
