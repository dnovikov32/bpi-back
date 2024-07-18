<?php

declare(strict_types=1);

namespace App\Console\Share\Import;

use App\Common\Importer\ImporterInterface;
use App\Common\Importer\ImportOptionsInterface;
use Exception;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Tinkoff\Invest\V1\InstrumentStatus;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

final class Command extends SymfonyCommand implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
        private readonly ImporterInterface $apiImporter,
    ) {
        parent::__construct();
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Shares import from API started');

        try {
            $progressBar = new ProgressBar($output);
            $progressBar->start();

            $this->apiImporter->import($this->getImportOptions($progressBar));

            $progressBar->finish();
        } catch (Exception $e) {
            $this->logger->error(
                sprintf('Import failed %s from API. %s', $this->getName(), $e->getMessage()),
                ['exception' => $e]
            );

            $io->error(sprintf('Shares import failed: %s', $e->getMessage()));

            return self::FAILURE;
        }

        $io->success('Shares import completed');

        return self::SUCCESS;
    }

    private function getImportOptions(ProgressBar $progressBar): ImportOptionsInterface
    {
        return new Options(
            instrumentStatus: InstrumentStatus::INSTRUMENT_STATUS_BASE,
            progressBar: $progressBar,
        );
    }
}
