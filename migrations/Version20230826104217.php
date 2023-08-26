<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230826104217 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE route DROP FOREIGN KEY FK_2C42079823CE13F');
        $this->addSql('DROP INDEX IDX_2C42079823CE13F ON route');
        $this->addSql('ALTER TABLE route DROP conveyor_id_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE route ADD conveyor_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE route ADD CONSTRAINT FK_2C42079823CE13F FOREIGN KEY (conveyor_id_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2C42079823CE13F ON route (conveyor_id_id)');
    }
}
