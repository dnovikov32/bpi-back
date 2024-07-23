<?php

declare(strict_types=1);

namespace App\Tests\Functional\Infrastracture\Repository;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Trader\Dto\ResultDto;
use App\Domain\Trader\Enum\MarketType;
use App\Domain\Trader\Factory\BrokerFactory;
use App\Domain\Trader\Factory\ResultFactory;
use App\Domain\Trader\Factory\TraderFactory;
use App\Domain\Trader\Model\Result;
use App\Domain\Trader\Repository\ResultRepositoryInterface;
use App\Tests\Resource\Fixture\ResultFixture;
use App\Tests\Tool\DatabaseToolTrait;
use App\Tests\Tool\FakerTrait;
use DateTimeImmutable;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ResultRepositoryTest extends WebTestCase
{
    use DatabaseToolTrait;
    use FakerTrait;

    private ResultRepositoryInterface $resultRepository;
    private TraderFactory $traderFactory;
    private BrokerFactory $brokerFactory;
    private ResultFactory $resultFactory;

    public function setUp(): void
    {
        parent::setUp();

        $container = static::getContainer();

        /** @var ResultRepositoryInterface $resultRepository */
        $resultRepository = $container->get('app.domain.trader.repository.result_repository_interface');
        $this->resultRepository = $resultRepository;

        /** @var TraderFactory $traderFactory */
        $traderFactory = $container->get('app.domain.trader.factory.trader_factory');
        $this->traderFactory = $traderFactory;

        /** @var BrokerFactory $brokerFactory */
        $brokerFactory = $container->get('app.domain.trader.factory.broker_factory');
        $this->brokerFactory = $brokerFactory;

        /** @var ResultFactory $resultFactory */
        $resultFactory = $container->get('app.domain.trader.factory.result_factory');
        $this->resultFactory = $resultFactory;
    }

    /**
     * @throws EntityNotFoundException
     * @throws Exception
     */
    public function testResultCreatedSuccessfully(): void
    {
        $trader = $this->traderFactory->create(
            year: (int) $this->getFaker()->year(),
            moexId: $this->getFaker()->randomNumber(6),
            name: $this->getFaker()->name(),
        );

        $broker = $this->brokerFactory->create(
            name: $this->getFaker()->company(),
        );

        $result = $this->resultFactory->create(
            new ResultDto(
                trader: $trader,
                broker: $broker,
                relevantDate: DateTimeImmutable::createFromMutable($this->getFaker()->dateTime()),
                startDate: DateTimeImmutable::createFromMutable($this->getFaker()->dateTime()),
                marketType: MarketType::from('Фондовый'),
                initialCapital: $this->getFaker()->randomFloat(2),
                profit: $this->getFaker()->randomFloat(2),
                profitPercentage: $this->getFaker()->randomFloat(3, 1, 100),
                dealCount: $this->getFaker()->randomNumber(),
                volume: $this->getFaker()->randomFloat(2),
                active: $this->getFaker()->boolean(),
            )
        );

        $this->resultRepository->save($result);
        $existedResult = $this->resultRepository->findByTraderIdAndMarketType(
            traderId: $result->getTrader()->getId(),
            marketType: $result->getMarketType()
        );

        $this->assertEquals($result->getId(), $existedResult->getId());
    }

    /**
     * @throws EntityNotFoundException
     * @throws Exception
     */
    public function testResultFoundByTraderIdAndMarketTypeSuccessfully(): void
    {
        $executor = $this->getDatabaseTool()->loadFixtures([ResultFixture::class]);

        /** @var Result $result */
        $result = $executor->getReferenceRepository()->getReference(ResultFixture::REFERENCE);
        $existedResult = $this->resultRepository->findByTraderIdAndMarketType(
            traderId: $result->getTrader()->getId(),
            marketType: $result->getMarketType()
        );

        $this->assertEquals($result->getId(), $existedResult->getId());
    }
}
