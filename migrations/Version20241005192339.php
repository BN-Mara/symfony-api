<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241005192339 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE line ADD enterprise_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE line ADD CONSTRAINT FK_D114B4F6A97D1AC3 FOREIGN KEY (enterprise_id) REFERENCES enterprise (id)');
        $this->addSql('CREATE INDEX IDX_D114B4F6A97D1AC3 ON line (enterprise_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE line DROP FOREIGN KEY FK_D114B4F6A97D1AC3');
        $this->addSql('DROP INDEX IDX_D114B4F6A97D1AC3 ON line');
        $this->addSql('ALTER TABLE line DROP enterprise_id');
    }
}
