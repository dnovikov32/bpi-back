<?php

declare(strict_types=1);

namespace App\Tests\Resource\Fixture;

use App\Domain\Common\Service\IdService;
use App\Domain\Instrument\Factory\ShareFactory;
use App\Tests\Tool\FakerTrait;
use DateTimeImmutable;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

final class ShareFixture extends Fixture
{
    use FakerTrait;

    public const REFERENCE = 'share';

    public function load(ObjectManager $manager): void
    {
        $shareFactory = new ShareFactory(new IdService());

        $share = $shareFactory->create(
            figi: mb_strtoupper($this->getFaker()->lexify('????????????')),
            ticker: mb_strtoupper($this->getFaker()->lexify('????')),
            isin: mb_strtoupper($this->getFaker()->lexify('????????????')),
            lot: $this->getFaker()->randomNumber(3),
            currency: mb_strtolower($this->getFaker()->currencyCode()),
            name: $this->getFaker()->company(),
            uid: $this->getFaker()->uuid(),
            first1minCandleDate: DateTimeImmutable::createFromMutable($this->getFaker()->dateTime()),
            first1dayCandleDate: DateTimeImmutable::createFromMutable($this->getFaker()->dateTime()),
        );

        $manager->persist($share);
        $manager->flush();

        $this->addReference(self::REFERENCE, $share);
    }
}
