<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231102083604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE kilometer_track (id INT AUTO_INCREMENT NOT NULL, vehicle_id INT NOT NULL, driver_id INT NOT NULL, created_at DATETIME DEFAULT NULL, kilometer DOUBLE PRECISION NOT NULL, INDEX IDX_A8395CD9545317D1 (vehicle_id), INDEX IDX_A8395CD9C3423909 (driver_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE kilometer_track ADD CONSTRAINT FK_A8395CD9545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE kilometer_track ADD CONSTRAINT FK_A8395CD9C3423909 FOREIGN KEY (driver_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vehicle ADD kilometer DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE kilometer_track DROP FOREIGN KEY FK_A8395CD9545317D1');
        $this->addSql('ALTER TABLE kilometer_track DROP FOREIGN KEY FK_A8395CD9C3423909');
        $this->addSql('DROP TABLE kilometer_track');
        $this->addSql('ALTER TABLE vehicle DROP kilometer');
    }
}
