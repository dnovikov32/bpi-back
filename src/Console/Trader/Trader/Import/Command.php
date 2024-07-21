<?php

declare(strict_types=1);

namespace App\Console\Trader\Trader\Import;

use App\Common\Importer\ImporterInterface;
use App\Common\Importer\ImportOptionsInterface;
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
        private readonly ImporterInterface $apiImporter
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->addArgument(
            'year',
            InputArgument::REQUIRED,
            'Year',
        );
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Traders import from API started');

        try {
            $progressBar = new ProgressBar($output, 10);
            $progressBar->start();

            $this->apiImporter->import($this->getImportOptions($input, $progressBar));

            $progressBar->finish();
        } catch (Exception $e) {
            $this->logger->error(
                sprintf('Traders import failed %s from API. %s', $this->getName(), $e->getMessage()),
                ['exception' => $e]
            );

            $io->error(sprintf('Traders import failed: %s', $e->getMessage()));

            return self::FAILURE;
        }

        $io->success('Traders import completed');

        return self::SUCCESS;
    }

    private function getImportOptions(InputInterface $input, ProgressBar $progressBar): ImportOptionsInterface
    {
        return new Options(
            year: (int) $input->getArgument('year'),
            progressBar: $progressBar,
        );
    }
}
