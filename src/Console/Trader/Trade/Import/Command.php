<?php

declare(strict_types=1);

namespace App\Console\Trader\Trade\Import;

use App\Common\Importer\ImportOptionsInterface;
use App\Console\Common\BaseImportFromApiWithProgressbar;
use App\Domain\Trader\Enum\MarketType;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;

final class Command extends BaseImportFromApiWithProgressbar
{
    protected function configure(): void
    {
        $this->addArgument(
            'year',
            InputArgument::REQUIRED,
            'Year',
        );

        $this->addArgument(
            'traderMoexId',
            InputArgument::REQUIRED,
            'Trader moex ID',
        );

        $this->addArgument(
            'marketTypeValue',
            InputArgument::REQUIRED,
            'Market type value',
        );
    }

    protected function getImportOptions(InputInterface $input): ImportOptionsInterface
    {
        return new Options(
            year: (int) $input->getArgument('year'),
            traderMoexId: (int) $input->getArgument('traderMoexId'),
            marketType: MarketType::fromValue((int) $input->getArgument('marketTypeValue')),
        );
    }
}
