<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240731172706 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table trader_trade';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE trader_trade (
            id VARCHAR(26) NOT NULL,
            trader_id VARCHAR(26) NOT NULL,
            share_id VARCHAR(26) NOT NULL,
            market_type SMALLINT NOT NULL,
            date_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            price DOUBLE PRECISION NOT NULL,
            volume INT NOT NULL,
            PRIMARY KEY(id)
        )');

        $this->addSql('CREATE INDEX trader_trade_trader_id_idx ON trader_trade (trader_id)');
        $this->addSql('CREATE INDEX trader_trade_share_id_idx ON trader_trade (share_id)');
        $this->addSql('CREATE INDEX trader_trade_date_time_idx ON trader_trade (date_time)');

        $this->addSql('ALTER TABLE trader_trade ADD CONSTRAINT trader_trade_trader_id_fk FOREIGN KEY (trader_id) REFERENCES trader_trader (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE trader_trade ADD CONSTRAINT trader_trade_share_id_fk FOREIGN KEY (share_id) REFERENCES instrument_share (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql('COMMENT ON COLUMN trader_trade.date_time IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE trader_trade DROP CONSTRAINT trader_trade_trader_id_fk');
        $this->addSql('ALTER TABLE trader_trade DROP CONSTRAINT trader_trade_share_id_fk');
        $this->addSql('DROP TABLE trader_trade');
    }
}
