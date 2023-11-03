<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231102131749 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE carburant (id INT AUTO_INCREMENT NOT NULL, vehicle_id INT NOT NULL, quantity DOUBLE PRECISION NOT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_B46A330A545317D1 (vehicle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE carburant ADD CONSTRAINT FK_B46A330A545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE ticket_price ADD region_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE ticket_price ADD CONSTRAINT FK_E2F8415298260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('CREATE INDEX IDX_E2F8415298260155 ON ticket_price (region_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE carburant DROP FOREIGN KEY FK_B46A330A545317D1');
        $this->addSql('DROP TABLE carburant');
        $this->addSql('ALTER TABLE ticket_price DROP FOREIGN KEY FK_E2F8415298260155');
        $this->addSql('DROP INDEX IDX_E2F8415298260155 ON ticket_price');
        $this->addSql('ALTER TABLE ticket_price DROP region_id');
    }
}
