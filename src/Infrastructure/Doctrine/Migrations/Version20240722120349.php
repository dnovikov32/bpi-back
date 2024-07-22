<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240722120349 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table trader_broker';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE trader_broker (
            id VARCHAR(26) NOT NULL,
            name VARCHAR(255) NOT NULL,
            PRIMARY KEY(id))
        ');

        $this->addSql('CREATE UNIQUE INDEX trader_broker_name_unq ON trader_broker (name)');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE trader_broker');
    }
}
