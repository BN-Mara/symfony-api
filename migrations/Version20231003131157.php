<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231003131157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE nfc_card (id INT AUTO_INCREMENT NOT NULL, uid VARCHAR(64) NOT NULL, card_holder VARCHAR(64) DEFAULT NULL, phone_number VARCHAR(20) DEFAULT NULL, balance DOUBLE PRECISION NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE transaction (id INT AUTO_INCREMENT NOT NULL, card_id INT DEFAULT NULL, amount DOUBLE PRECISION NOT NULL, route_id INT DEFAULT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_723705D14ACC9A20 (card_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D14ACC9A20 FOREIGN KEY (card_id) REFERENCES nfc_card (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D14ACC9A20');
        $this->addSql('DROP TABLE nfc_card');
        $this->addSql('DROP TABLE transaction');
    }
}
