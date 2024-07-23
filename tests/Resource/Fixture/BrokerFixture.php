<?php

declare(strict_types=1);

namespace App\Tests\Resource\Fixture;

use App\Domain\Common\Service\IdService;
use App\Domain\Trader\Factory\BrokerFactory;
use App\Tests\Tool\FakerTrait;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class BrokerFixture extends Fixture
{
    use FakerTrait;

    public const REFERENCE = 'broker';

    public function load(ObjectManager $manager): void
    {
        $brokerFactory = new BrokerFactory(new IdService());

        $broker = $brokerFactory->create(
            name: $this->getFaker()->name()
        );

        $manager->persist($broker);
        $manager->flush();

        $this->addReference(self::REFERENCE, $broker);
    }
}
