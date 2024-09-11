<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240911113858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE driver (id INT AUTO_INCREMENT NOT NULL, fleet_set_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_11667CD99BF0AA28 (fleet_set_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fleet_set (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE trailer (id INT AUTO_INCREMENT NOT NULL, fleet_set_id INT NOT NULL, name VARCHAR(255) NOT NULL, status VARCHAR(8) NOT NULL, UNIQUE INDEX UNIQ_C691DC4E9BF0AA28 (fleet_set_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE truck (id INT AUTO_INCREMENT NOT NULL, fleet_set_id INT NOT NULL, manufacturer VARCHAR(255) NOT NULL, model VARCHAR(255) NOT NULL, license_plate VARCHAR(255) NOT NULL, status VARCHAR(8) NOT NULL, UNIQUE INDEX UNIQ_CDCCF30A9BF0AA28 (fleet_set_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE driver ADD CONSTRAINT FK_11667CD99BF0AA28 FOREIGN KEY (fleet_set_id) REFERENCES fleet_set (id)');
        $this->addSql('ALTER TABLE trailer ADD CONSTRAINT FK_C691DC4E9BF0AA28 FOREIGN KEY (fleet_set_id) REFERENCES fleet_set (id)');
        $this->addSql('ALTER TABLE truck ADD CONSTRAINT FK_CDCCF30A9BF0AA28 FOREIGN KEY (fleet_set_id) REFERENCES fleet_set (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE driver DROP FOREIGN KEY FK_11667CD99BF0AA28');
        $this->addSql('ALTER TABLE trailer DROP FOREIGN KEY FK_C691DC4E9BF0AA28');
        $this->addSql('ALTER TABLE truck DROP FOREIGN KEY FK_CDCCF30A9BF0AA28');
        $this->addSql('DROP TABLE driver');
        $this->addSql('DROP TABLE fleet_set');
        $this->addSql('DROP TABLE trailer');
        $this->addSql('DROP TABLE truck');
    }
}
