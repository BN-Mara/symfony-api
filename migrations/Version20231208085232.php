<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231208085232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recharge_carte ADD old_balance DOUBLE PRECISION DEFAULT NULL, ADD new_balance DOUBLE PRECISION DEFAULT NULL');
        $this->addSql('ALTER TABLE transaction ADD old_balance DOUBLE PRECISION DEFAULT NULL, ADD new_balance DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recharge_carte DROP old_balance, DROP new_balance');
        $this->addSql('ALTER TABLE transaction DROP old_balance, DROP new_balance');
    }
}
