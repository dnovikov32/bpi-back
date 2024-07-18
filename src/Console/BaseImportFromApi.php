<?php

declare(strict_types=1);

namespace App\Console;

use App\Common\Importer\ImporterInterface;
use App\Common\Importer\ImportOptionsInterface;
use Exception;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

abstract class BaseImportFromApi extends Command implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
        private readonly ImporterInterface $apiImporter,
        LoggerInterface $logger,
        ?string $name = null
    ) {
        parent::__construct($name);

        $this->setLogger($logger);
    }

    abstract protected function getImportParameters(InputInterface $input): ImportOptionsInterface;

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Import from API started');

        try {
            $this->apiImporter->import($this->getImportParameters($input));
        } catch (Exception $e) {
            $this->logger->error(
                sprintf('Import failed %s from API. %s', $this->getName(), $e->getMessage()),
                ['exception' => $e]
            );

            $io->error(sprintf('Import failed: %s', $e->getMessage()));

            return self::FAILURE;
        }

        $io->success('Import completed');

        return self::SUCCESS;
    }
}
