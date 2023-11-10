<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231110094940 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE versement (id INT AUTO_INCREMENT NOT NULL, vehicle_id INT NOT NULL, driver_id INT DEFAULT NULL, amount DOUBLE PRECISION NOT NULL, created_at DATETIME DEFAULT NULL, created_by VARCHAR(32) NOT NULL, INDEX IDX_716E9367545317D1 (vehicle_id), INDEX IDX_716E9367C3423909 (driver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE versement ADD CONSTRAINT FK_716E9367545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE versement ADD CONSTRAINT FK_716E9367C3423909 FOREIGN KEY (driver_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE versement DROP FOREIGN KEY FK_716E9367545317D1');
        $this->addSql('ALTER TABLE versement DROP FOREIGN KEY FK_716E9367C3423909');
        $this->addSql('DROP TABLE versement');
    }
}
