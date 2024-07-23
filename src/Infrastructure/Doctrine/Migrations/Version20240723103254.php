<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240723103254 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table trader_result';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE trader_result (
            id VARCHAR(26) NOT NULL,
            trader_id VARCHAR(26) DEFAULT NULL,
            broker_id VARCHAR(26) DEFAULT NULL,
            market_type SMALLINT NOT NULL,
            relevant_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            start_date TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            initial_capital DOUBLE PRECISION NOT NULL,
            profit DOUBLE PRECISION NOT NULL,
            profit_percentage DOUBLE PRECISION NOT NULL,
            deal_count INT NOT NULL,
            volume DOUBLE PRECISION NOT NULL,
            active BOOLEAN NOT NULL,
            PRIMARY KEY(id)
       )');

        $this->addSql('ALTER TABLE trader_result ADD CONSTRAINT trader_result_trader_id_fk FOREIGN KEY (trader_id) REFERENCES trader_trader (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE trader_result ADD CONSTRAINT trader_result_broker_id_fk FOREIGN KEY (broker_id) REFERENCES trader_broker (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql('CREATE INDEX trader_result_trader_id_idx ON trader_result (trader_id)');
        $this->addSql('CREATE INDEX trader_result_broker_id_idx ON trader_result (broker_id)');

        $this->addSql('CREATE UNIQUE INDEX trader_result_trader_id_market_type_idx ON trader_result (trader_id, market_type)');

        $this->addSql('COMMENT ON COLUMN trader_result.relevant_date IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN trader_result.start_date IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE trader_result DROP CONSTRAINT trader_result_broker_id_fk');
        $this->addSql('ALTER TABLE trader_result DROP CONSTRAINT trader_result_trader_id_fk');
        $this->addSql('DROP TABLE trader_result');
    }
}
