<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231020103428 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE recharge_carte (id INT AUTO_INCREMENT NOT NULL, uid_carte VARCHAR(32) NOT NULL, amount DOUBLE PRECISION NOT NULL, created_at DATETIME DEFAULT NULL, created_by VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE recharge_user (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, amount DOUBLE PRECISION NOT NULL, created_at DATETIME DEFAULT NULL, created_by VARCHAR(64) DEFAULT NULL, INDEX IDX_CBFA9E2FA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rechargeur (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE recharge_user ADD CONSTRAINT FK_CBFA9E2FA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user ADD balance DOUBLE PRECISION DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE recharge_user DROP FOREIGN KEY FK_CBFA9E2FA76ED395');
        $this->addSql('DROP TABLE recharge_carte');
        $this->addSql('DROP TABLE recharge_user');
        $this->addSql('DROP TABLE rechargeur');
        $this->addSql('ALTER TABLE user DROP balance, DROP updated_at');
    }
}
