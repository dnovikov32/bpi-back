<?php

declare(strict_types=1);

namespace App\Tests\Resource\Fixture;

use App\Domain\Common\Service\IdService;
use App\Domain\Trader\Factory\TraderFactory;
use App\Tests\Tool\FakerTrait;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class TraderFixture extends Fixture
{
    use FakerTrait;

    public const REFERENCE = 'trader';

    public function load(ObjectManager $manager): void
    {
        $traderFactory = new TraderFactory(new IdService());

        $trader = $traderFactory->create(
            year: (int) $this->getFaker()->year(),
            moexId: $this->getFaker()->randomNumber(6),
            name: $this->getFaker()->name(),
        );

        $manager->persist($trader);
        $manager->flush();

        $this->addReference(self::REFERENCE, $trader);
    }
}
