<?php

declare(strict_types=1);

namespace App\Tests\Functional\Console\Trader\Trader\Import;

use App\Console\Trader\Trader\Import\Dto\ImportTraderDto;
use App\Console\Trader\Trader\Import\Importer;
use App\Console\Trader\Trader\Import\Options;
use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Trader\Repository\TraderRepositoryInterface;
use App\Tests\Tool\HttpClientTrait;
use GuzzleHttp\Psr7\Response;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class ImporterTest extends WebTestCase
{
    use HttpClientTrait;

    private const YEAR = 2022;
    private const FILE_PATH = '/app/tests/Functional/Console/Trader/Trader/Import/trader.csv';
    private const SEPARATOR = ';';
    private const FROM_ENCODING = 'CP1251';
    private const TO_ENCODING = 'UTF-8';

    private Importer $traderImporter;
    private TraderRepositoryInterface $traderRepository;

    public function setUp(): void
    {
        parent::setUp();

        $container = static::getContainer();

        /** @var Importer $traderImporter */
        $traderImporter = $container->get('app.console.trader.trader.import.importer');
        $this->traderImporter = $traderImporter;

        /** @var TraderRepositoryInterface $traderRepository */
        $traderRepository = $container->get('app.domain.trader.repository.trader_repository_interface');
        $this->traderRepository = $traderRepository;
    }

    /**
     * @throws EntityNotFoundException
     */
    public function testImportedSuccessfully(): void
    {
        $fileContent = file_get_contents(self::FILE_PATH);

        $response = new Response(HttpResponse::HTTP_OK, [], $fileContent);
        $this->getHttpClientMockHandler()->append($response);

        $this->traderImporter->import(new Options(self::YEAR));

        foreach ($this->getTradersFromFile($fileContent) as $traderFromFile) {
            $existedTrader = $this->traderRepository->findByYearAndMoexId($traderFromFile->year, $traderFromFile->id);
            $this->assertEquals($traderFromFile->name, $existedTrader->getName());
        }
    }

    /**
     * @return ImportTraderDto[]
     */
    private function getTradersFromFile(string $fileContent): array
    {
        $rows = explode(PHP_EOL, $fileContent);
        $traders = [];

        foreach ($rows as $row) {
            $columns = array_filter(str_getcsv($row, self::SEPARATOR));

            if ($columns === []) {
                continue;
            }

            $traders[] = new ImportTraderDto(
                year: self::YEAR,
                id: (int) $columns[1],
                name: mb_convert_encoding($columns[0], self::TO_ENCODING, self::FROM_ENCODING),
            );
        }

        return $traders;
    }
}
