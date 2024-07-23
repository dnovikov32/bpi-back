<?php

declare(strict_types=1);

namespace App\Tests\Functional\Infrastracture\Repository;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Trader\Factory\BrokerFactory;
use App\Domain\Trader\Repository\BrokerRepositoryInterface;
use App\Tests\Resource\Fixture\BrokerFixture;
use App\Tests\Tool\DatabaseToolTrait;
use App\Tests\Tool\FakerTrait;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BrokerRepositoryTest extends WebTestCase
{
    use DatabaseToolTrait;
    use FakerTrait;

    private BrokerFactory $brokerFactory;
    private BrokerRepositoryInterface $brokerRepository;

    public function setUp(): void
    {
        parent::setUp();

        /** @var BrokerFactory $brokerFactory */
        $brokerFactory = $this->getContainer()->get('app.domain.trader.factory.broker_factory');
        $this->brokerFactory = $brokerFactory;

        $this->brokerRepository  = $this->getContainer()->get('app.domain.trader.repository.broker_repository_interface');

    }

    /**
     * @throws EntityNotFoundException
     * @throws Exception
     */
    public function testBrokerCreatedSuccessfully(): void
    {
        $broker = $this->brokerFactory->create(
            name: $this->getFaker()->company(),
        );

        $this->brokerRepository->save($broker);
        $existedBroker = $this->brokerRepository->findByName($broker->getName());

        $this->assertEquals($broker->getId(), $existedBroker->getId());
    }

    /**
     * @throws EntityNotFoundException
     * @throws Exception
     */
    public function testBrokerFoundByNameSuccessfully(): void
    {
        $executor = $this->getDatabaseTool()->loadFixtures([BrokerFixture::class]);
        $broker = $executor->getReferenceRepository()->getReference(BrokerFixture::REFERENCE);

        $existedBroker = $this->brokerRepository->findByName($broker->getName());

        $this->assertEquals($broker->getId(), $existedBroker->getId());
    }
}
