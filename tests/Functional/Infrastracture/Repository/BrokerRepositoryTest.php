<?php

declare(strict_types=1);

namespace App\Tests\Functional\Infrastracture\Repository;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Trader\Factory\BrokerFactory;
use App\Domain\Trader\Repository\BrokerRepositoryInterface;
use Exception;
use Faker\Factory;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class BrokerRepositoryTest extends WebTestCase
{
    private BrokerFactory $brokerFactory;
    private BrokerRepositoryInterface $brokerRepository;
    private Generator $faker;

    public function setUp(): void
    {
        parent::setUp();

        /** @var BrokerFactory $brokerFactory */
        $brokerFactory = $this->getContainer()->get('app.domain.trader.factory.broker_factory');
        $this->brokerFactory = $brokerFactory;

        $this->brokerRepository  = $this->getContainer()->get('app.domain.trader.repository.broker_repository_interface');

        $this->faker = Factory::create();
    }

    /**
     * @throws EntityNotFoundException
     * @throws Exception
     */
    public function testShareCreatedSuccessfully(): void
    {
        $broker = $this->brokerFactory->create(
            name: $this->faker->company(),
        );

        $this->brokerRepository->save($broker);
        $existedBroker = $this->brokerRepository->findByName($broker->getName());

        $this->assertEquals($broker->getId(), $existedBroker->getId());
    }
}
