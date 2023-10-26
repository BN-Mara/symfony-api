<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231023191718 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket_price ADD description VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE user ADD vehicle_id INT DEFAULT NULL, ADD photo VARCHAR(255) DEFAULT NULL, ADD identity_card VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('CREATE INDEX IDX_8D93D649545317D1 ON user (vehicle_id)');
        $this->addSql('ALTER TABLE vehicle ADD volet_jaune VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ticket_price DROP description');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649545317D1');
        $this->addSql('DROP INDEX IDX_8D93D649545317D1 ON user');
        $this->addSql('ALTER TABLE user DROP vehicle_id, DROP photo, DROP identity_card');
        $this->addSql('ALTER TABLE vehicle DROP volet_jaune');
    }
}
