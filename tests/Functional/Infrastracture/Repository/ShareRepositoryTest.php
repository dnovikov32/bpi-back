<?php

declare(strict_types=1);

namespace App\Tests\Functional\Infrastracture\Repository;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Instrument\Factory\ShareFactory;
use App\Domain\Instrument\Repository\ShareRepositoryInterface;
use DateTimeImmutable;
use Exception;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ShareRepositoryTest extends WebTestCase
{
    private ShareFactory $shareFactory;
    private ShareRepositoryInterface $shareRepository;
    private Generator $faker;

    public function setUp(): void
    {
        parent::setUp();

        /** @var ShareFactory $shareFactory */
        $shareFactory = $this->getContainer()->get('app.domain.instrument.factory.share_factory');
        $this->shareFactory = $shareFactory;

        $this->shareRepository  = $this->getContainer()->get('app.domain.instrument.repository.share_repository_interface');

        $this->faker = Factory::create();
    }

    /**
     * @throws EntityNotFoundException
     * @throws Exception
     */
    public function testShareCreatedSuccessfully(): void
    {
        $share = $this->shareFactory->create(
            figi: mb_strtoupper($this->faker->lexify('????????????')),
            ticker: mb_strtoupper($this->faker->lexify('????')),
            isin: mb_strtoupper($this->faker->lexify('????????????')),
            lot: $this->faker->randomNumber(3),
            currency: mb_strtolower($this->faker->currencyCode()),
            name: $this->faker->company(),
            uid: $this->faker->uuid(),
            first1minCandleDate: DateTimeImmutable::createFromMutable($this->faker->dateTime()),
            first1dayCandleDate: DateTimeImmutable::createFromMutable($this->faker->dateTime()),
        );

        $this->shareRepository->save($share);
        $existedShare = $this->shareRepository->findByTicker($share->getTicker());

        $this->assertEquals($share->getId(), $existedShare->getId());
    }
}
