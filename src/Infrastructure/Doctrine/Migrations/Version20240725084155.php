<?php

declare(strict_types=1);

namespace App\Infrastructure\Doctrine\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240725084155 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create table marketdata_candle';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE marketdata_candle (
            id VARCHAR(26) NOT NULL,
            share_id VARCHAR(26) NOT NULL,
            date_time TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            open DOUBLE PRECISION NOT NULL,
            close DOUBLE PRECISION NOT NULL,
            high DOUBLE PRECISION NOT NULL,
            low DOUBLE PRECISION NOT NULL,
            volume INT NOT NULL, PRIMARY KEY(id)
        )');

        $this->addSql('ALTER TABLE marketdata_candle ADD CONSTRAINT marketdata_candle_share_id_fk FOREIGN KEY (share_id) REFERENCES instrument_share (id) NOT DEFERRABLE INITIALLY IMMEDIATE');

        $this->addSql('CREATE INDEX marketdata_candle_date_time_idx ON marketdata_candle (date_time)');
        $this->addSql('CREATE INDEX marketdata_candle_share_id_idx ON marketdata_candle (share_id)');

        $this->addSql('COMMENT ON COLUMN marketdata_candle.date_time IS \'(DC2Type:datetime_immutable)\'');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE marketdata_candle DROP CONSTRAINT marketdata_candle_share_id_fk');
        $this->addSql('DROP TABLE marketdata_candle');
    }
}
