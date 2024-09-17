<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240917220653 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE driver_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE fleet_set_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "order_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE trailer_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE truck_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE driver (id INT NOT NULL, fleet_set_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_11667CD99BF0AA28 ON driver (fleet_set_id)');
        $this->addSql('COMMENT ON COLUMN driver.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN driver.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE fleet_set (id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN fleet_set.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN fleet_set.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE "order" (id INT NOT NULL, name VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, status VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "order".created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "order".updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE order_fleet_set (order_id INT NOT NULL, fleet_set_id INT NOT NULL, PRIMARY KEY(order_id, fleet_set_id))');
        $this->addSql('CREATE INDEX IDX_F56D7A128D9F6D38 ON order_fleet_set (order_id)');
        $this->addSql('CREATE INDEX IDX_F56D7A129BF0AA28 ON order_fleet_set (fleet_set_id)');
        $this->addSql('CREATE TABLE trailer (id INT NOT NULL, fleet_set_id INT NOT NULL, name VARCHAR(255) NOT NULL, status VARCHAR(8) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C691DC4E9BF0AA28 ON trailer (fleet_set_id)');
        $this->addSql('COMMENT ON COLUMN trailer.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN trailer.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('CREATE TABLE truck (id INT NOT NULL, fleet_set_id INT NOT NULL, manufacturer VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, license_plate VARCHAR(255) NOT NULL, status VARCHAR(8) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CDCCF30A9BF0AA28 ON truck (fleet_set_id)');
        $this->addSql('COMMENT ON COLUMN truck.created_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN truck.updated_at IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE driver ADD CONSTRAINT FK_11667CD99BF0AA28 FOREIGN KEY (fleet_set_id) REFERENCES fleet_set (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_fleet_set ADD CONSTRAINT FK_F56D7A128D9F6D38 FOREIGN KEY (order_id) REFERENCES "order" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE order_fleet_set ADD CONSTRAINT FK_F56D7A129BF0AA28 FOREIGN KEY (fleet_set_id) REFERENCES fleet_set (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE trailer ADD CONSTRAINT FK_C691DC4E9BF0AA28 FOREIGN KEY (fleet_set_id) REFERENCES fleet_set (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE truck ADD CONSTRAINT FK_CDCCF30A9BF0AA28 FOREIGN KEY (fleet_set_id) REFERENCES fleet_set (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE driver_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE fleet_set_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE "order_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE trailer_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE truck_id_seq CASCADE');
        $this->addSql('ALTER TABLE driver DROP CONSTRAINT FK_11667CD99BF0AA28');
        $this->addSql('ALTER TABLE order_fleet_set DROP CONSTRAINT FK_F56D7A128D9F6D38');
        $this->addSql('ALTER TABLE order_fleet_set DROP CONSTRAINT FK_F56D7A129BF0AA28');
        $this->addSql('ALTER TABLE trailer DROP CONSTRAINT FK_C691DC4E9BF0AA28');
        $this->addSql('ALTER TABLE truck DROP CONSTRAINT FK_CDCCF30A9BF0AA28');
        $this->addSql('DROP TABLE driver');
        $this->addSql('DROP TABLE fleet_set');
        $this->addSql('DROP TABLE "order"');
        $this->addSql('DROP TABLE order_fleet_set');
        $this->addSql('DROP TABLE trailer');
        $this->addSql('DROP TABLE truck');
    }
}
