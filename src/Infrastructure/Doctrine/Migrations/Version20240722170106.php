<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240722170106 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table trader_result';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE trader_result (
            id VARCHAR(26) NOT NULL,
            broker_id VARCHAR(26) DEFAULT NULL,
            year SMALLINT NOT NULL,
            trader_id INT NOT NULL,
            market_type SMALLINT NOT NULL,
            relevant_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            initial_capital NUMERIC(2, 12) NOT NULL,
            profit NUMERIC(2, 12) NOT NULL,
            profit_percentage NUMERIC(3, 6) NOT NULL,
            deal_count INT NOT NULL,
            volume NUMERIC(2, 12) NOT NULL,
            active BOOLEAN NOT NULL,
            PRIMARY KEY(id)
        )');

        $this->addSql('ALTER TABLE trader_result ADD CONSTRAINT trader_result_broker_id_fk FOREIGN KEY (broker_id) REFERENCES trader_broker (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX trader_result_broker_id_idx ON trader_result (broker_id)');

        $this->addSql('CREATE UNIQUE INDEX trader_result_year_market_type_trader_id_idx ON trader_result (year, market_type, trader_id)');

        $this->addSql('COMMENT ON COLUMN trader_result.relevant_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN trader_result.start_date IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE trader_result DROP CONSTRAINT trader_result_broker_id_fk');
        $this->addSql('DROP TABLE trader_result');
    }
}
