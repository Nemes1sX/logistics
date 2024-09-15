<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240915220003 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', status VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_fleet_set (order_id INT NOT NULL, fleet_set_id INT NOT NULL, INDEX IDX_F56D7A128D9F6D38 (order_id), INDEX IDX_F56D7A129BF0AA28 (fleet_set_id), PRIMARY KEY(order_id, fleet_set_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_fleet_set ADD CONSTRAINT FK_F56D7A128D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_fleet_set ADD CONSTRAINT FK_F56D7A129BF0AA28 FOREIGN KEY (fleet_set_id) REFERENCES fleet_set (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_fleet_set DROP FOREIGN KEY FK_F56D7A128D9F6D38');
        $this->addSql('ALTER TABLE order_fleet_set DROP FOREIGN KEY FK_F56D7A129BF0AA28');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_fleet_set');
    }
}
