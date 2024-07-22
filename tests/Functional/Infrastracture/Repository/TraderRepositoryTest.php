<?php

declare(strict_types=1);

namespace App\Tests\Functional\Infrastracture\Repository;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Trader\Factory\TraderFactory;
use App\Domain\Trader\Repository\TraderRepositoryInterface;
use Exception;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TraderRepositoryTest extends WebTestCase
{
    private TraderFactory $traderFactory;
    private TraderRepositoryInterface $traderRepository;
    private Generator $faker;

    public function setUp(): void
    {
        parent::setUp();

        /** @var TraderFactory $traderFactory */
        $traderFactory = $this->getContainer()->get('app.domain.trader.factory.trader_factory');
        $this->traderFactory = $traderFactory;

        $this->traderRepository  = $this->getContainer()->get('app.domain.trader.repository.trader_repository_interface');

        $this->faker = Factory::create();
    }

    /**
     * @throws EntityNotFoundException
     * @throws Exception
     */
    public function testTraderCreatedSuccessfully(): void
    {
        $trader = $this->traderFactory->create(
            year: (int) $this->faker->year(),
            moexId: $this->faker->randomNumber(6),
            name: $this->faker->name(),
        );

        $this->traderRepository->save($trader);
        $existedTrader = $this->traderRepository->findByYearAndMoexId($trader->getYear(), $trader->getMoexId());

        $this->assertEquals($trader->getId(), $existedTrader->getId());
    }
}
