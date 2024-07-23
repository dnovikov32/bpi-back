<?php

declare(strict_types=1);

namespace App\Tests\Resource\Fixture;

use App\Domain\Common\Service\IdService;
use App\Domain\Trader\Dto\ResultDto;
use App\Domain\Trader\Enum\MarketType;
use App\Domain\Trader\Factory\ResultFactory;
use App\Tests\Tool\FakerTrait;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

final class ResultFixture extends Fixture implements DependentFixtureInterface
{
    use FakerTrait;

    public const REFERENCE = 'result';

    public function load(ObjectManager $manager): void
    {
        $resultFactory = new ResultFactory(new IdService());

        $trader = $this->getReference(TraderFixture::REFERENCE);
        $broker = $this->getReference(BrokerFixture::REFERENCE);

        $result = $resultFactory->create(
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

        $manager->persist($result);
        $manager->flush();

        $this->addReference(self::REFERENCE, $result);
    }

    public function getDependencies(): array
    {
        return [
            TraderFixture::class,
            BrokerFixture::class,
        ];
    }
}
