<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241005155741 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enterprise ADD created_at DATETIME DEFAULT NULL, ADD created_by VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE line ADD created_at DATETIME DEFAULT NULL, ADD created_by VARCHAR(100) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE enterprise DROP created_at, DROP created_by');
        $this->addSql('ALTER TABLE line DROP created_at, DROP created_by');
    }
}
