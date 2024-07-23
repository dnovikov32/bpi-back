<?php

declare(strict_types=1);

namespace App\Tests\Functional\Infrastracture\Repository;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Trader\Factory\TraderFactory;
use App\Domain\Trader\Entity\Trader;
use App\Domain\Trader\Repository\TraderRepositoryInterface;
use App\Tests\Resource\Fixture\TraderFixture;
use App\Tests\Tool\DatabaseToolTrait;
use App\Tests\Tool\FakerTrait;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TraderRepositoryTest extends WebTestCase
{
    use DatabaseToolTrait;
    use FakerTrait;

    private TraderFactory $traderFactory;
    private TraderRepositoryInterface $traderRepository;

    public function setUp(): void
    {
        parent::setUp();

        $container = static::getContainer();

        /** @var TraderRepositoryInterface $traderRepository */
        $traderRepository = $container->get('app.domain.trader.repository.trader_repository_interface');
        $this->traderRepository = $traderRepository;

        /** @var TraderFactory $traderFactory */
        $traderFactory = $container->get('app.domain.trader.factory.trader_factory');
        $this->traderFactory = $traderFactory;
    }

    /**
     * @throws EntityNotFoundException
     * @throws Exception
     */
    public function testTraderCreatedSuccessfully(): void
    {
        $trader = $this->traderFactory->create(
            year: (int) $this->getFaker()->year(),
            moexId: $this->getFaker()->randomNumber(6),
            name: $this->getFaker()->name(),
        );

        $this->traderRepository->save($trader);
        $existedTrader = $this->traderRepository->findByYearAndMoexId($trader->getYear(), $trader->getMoexId());

        $this->assertEquals($trader->getId(), $existedTrader->getId());
    }

    /**
     * @throws EntityNotFoundException
     * @throws Exception
     */
    public function testTraderFoundByYearAndMoexIdSuccessfully(): void
    {
        $executor = $this->getDatabaseTool()->loadFixtures([TraderFixture::class]);

        /** @var Trader $trader */
        $trader = $executor->getReferenceRepository()->getReference(TraderFixture::REFERENCE);
        $existedTrader = $this->traderRepository->findByYearAndMoexId($trader->getYear(), $trader->getMoexId());

        $this->assertEquals($trader->getId(), $existedTrader->getId());
    }
}
