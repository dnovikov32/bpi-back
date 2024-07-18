<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240718105759 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table share';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE share (
            id VARCHAR(26) NOT NULL,
            figi VARCHAR(12) NOT NULL,
            ticker VARCHAR(32) NOT NULL,
            isin VARCHAR(12) NOT NULL,
            lot INT NOT NULL,
            currency VARCHAR(3) NOT NULL,
            name VARCHAR(255) NOT NULL,
            uid VARCHAR(36) NOT NULL,
            first_1min_candle_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
            first_1day_candle_date TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
            PRIMARY KEY(id))
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE share');
    }
}
