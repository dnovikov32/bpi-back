<?php

declare(strict_types=1);

namespace App\Console\Common;

use App\Common\Importer\ImportOptionsInterface;
use App\Common\Importer\IterableImporterInterface;
use Exception;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

abstract class BaseImportFromApiWithProgressbar extends SymfonyCommand implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
        private readonly IterableImporterInterface $apiImporter
    ) {
        parent::__construct();
    }

    abstract protected function getImportOptions(InputInterface $input): ImportOptionsInterface;

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Import from API started');

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
                sprintf('Import from API `%s` failed: %s', $this->getName(), $e->getMessage()),
                ['exception' => $e]
            );

            $io->error(sprintf('Import from API failed: %s', $e->getMessage()));

            return self::FAILURE;
        }

        $io->success('Import from API completed');

        return self::SUCCESS;
    }
}
