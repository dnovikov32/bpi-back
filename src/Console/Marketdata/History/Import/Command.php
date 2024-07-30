<?php

declare(strict_types=1);

namespace App\Console\Marketdata\History\Import;

use App\Common\Importer\ImportOptionsInterface;
use App\Common\Importer\IterableImporterInterface;
use Exception;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class Command extends SymfonyCommand implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
        private readonly IterableImporterInterface $apiImporter
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument(
            'figi',
            InputArgument::REQUIRED,
            'Instrument figi',
        );

        $this->addArgument(
            'year',
            InputArgument::REQUIRED,
            'Year',
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Candles history import from API started');

        try {
            $progressBar = new ProgressBar($output);
            $progressBar->setFormat(ProgressBar::FORMAT_VERY_VERBOSE);
            $progressBar->start();

            $options = $this->getImportOptions($input);

            foreach ($this->apiImporter->import($options) as $_) {
                $progressBar->setMaxSteps($this->apiImporter->count());
                $progressBar->advance();
            }

            $progressBar->finish();
        } catch (Exception $e) {
            $this->logger->error(
                sprintf('Candles history import failed %s from API. %s', $this->getName(), $e->getMessage()),
                ['exception' => $e]
            );

            $io->error(sprintf('Candles history import failed: %s', $e->getMessage()));

            return self::FAILURE;
        }

        $io->success('Candles history import completed');

        return self::SUCCESS;
    }

    private function getImportOptions(InputInterface $input): ImportOptionsInterface
    {
        return new Options(
            figi: (string) $input->getArgument('figi'),
            year: (int) $input->getArgument('year'),
        );
    }
}
