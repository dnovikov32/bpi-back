<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240719210047 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table trader_trader';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE trader_trader (
            id VARCHAR(26) NOT NULL,
            year VARCHAR(4) NOT NULL,
            moex_id INT NOT NULL,
            name VARCHAR(32) NOT NULL,
            PRIMARY KEY(id))
        ');
        $this->addSql('CREATE UNIQUE INDEX trader_trader_year_moex_id_idx ON trader_trader (year, moex_id)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE trader_trader');
    }
}
