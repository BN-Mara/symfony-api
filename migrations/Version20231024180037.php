<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231024180037 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recharge_carte ADD card_id INT DEFAULT NULL, DROP uid_carte');
        $this->addSql('ALTER TABLE recharge_carte ADD CONSTRAINT FK_1E4352D84ACC9A20 FOREIGN KEY (card_id) REFERENCES nfc_card (id)');
        $this->addSql('CREATE INDEX IDX_1E4352D84ACC9A20 ON recharge_carte (card_id)');
        $this->addSql('ALTER TABLE transaction ADD CONSTRAINT FK_723705D134ECB4E6 FOREIGN KEY (route_id) REFERENCES route (id)');
        $this->addSql('CREATE INDEX IDX_723705D134ECB4E6 ON transaction (route_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recharge_carte DROP FOREIGN KEY FK_1E4352D84ACC9A20');
        $this->addSql('DROP INDEX IDX_1E4352D84ACC9A20 ON recharge_carte');
        $this->addSql('ALTER TABLE recharge_carte ADD uid_carte VARCHAR(32) NOT NULL, DROP card_id');
        $this->addSql('ALTER TABLE transaction DROP FOREIGN KEY FK_723705D134ECB4E6');
        $this->addSql('DROP INDEX IDX_723705D134ECB4E6 ON transaction');
    }
}
