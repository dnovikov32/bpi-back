<?php

declare(strict_types=1);

namespace App\Tests\Functional\Infrastracture\Repository;

use App\Domain\Common\Exception\EntityNotFoundException;
use App\Domain\Instrument\Factory\ShareFactory;
use App\Domain\Instrument\Repository\ShareRepositoryInterface;
use App\Tests\Tool\FakerTrait;
use DateTimeImmutable;
use Exception;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ShareRepositoryTest extends WebTestCase
{
    use FakerTrait;

    private ShareFactory $shareFactory;
    private ShareRepositoryInterface $shareRepository;

    public function setUp(): void
    {
        parent::setUp();

        $container = static::getContainer();

        /** @var ShareFactory $shareFactory */
        $shareFactory = $container->get('app.domain.instrument.factory.share_factory');
        $this->shareFactory = $shareFactory;

        $this->shareRepository = $container->get('app.domain.instrument.repository.share_repository_interface');
    }

    /**
     * @throws EntityNotFoundException
     * @throws Exception
     */
    public function testShareCreatedSuccessfully(): void
    {
        $share = $this->shareFactory->create(
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

        $this->shareRepository->save($share);
        $existedShare = $this->shareRepository->findByTicker($share->getTicker());

        $this->assertEquals($share->getId(), $existedShare->getId());
    }
}
