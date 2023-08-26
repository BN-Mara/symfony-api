<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230826140905 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE notification (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(128) NOT NULL, body VARCHAR(255) DEFAULT NULL, is_sent TINYINT(1) NOT NULL, created_at DATETIME DEFAULT NULL, sent_time DATETIME DEFAULT NULL, users LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', type VARCHAR(32) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE refresh_token (id INT AUTO_INCREMENT NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid DATETIME NOT NULL, UNIQUE INDEX UNIQ_C74F2195C74F2195 (refresh_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, reset_code VARCHAR(6) DEFAULT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE route (id INT AUTO_INCREMENT NOT NULL, vehicle_id INT NOT NULL, conveyor_id INT NOT NULL, destination VARCHAR(128) NOT NULL, ticket_price DOUBLE PRECISION DEFAULT NULL, start_lat DOUBLE PRECISION DEFAULT NULL, start_lng DOUBLE PRECISION DEFAULT NULL, end_lat DOUBLE PRECISION DEFAULT NULL, end_lng DOUBLE PRECISION DEFAULT NULL, passengers INT DEFAULT NULL, origine VARCHAR(128) NOT NULL, starting_time DATETIME DEFAULT NULL, ending_time DATETIME DEFAULT NULL, gpx LONGTEXT DEFAULT NULL, is_active TINYINT(1) DEFAULT NULL, INDEX IDX_2C42079545317D1 (vehicle_id), INDEX IDX_2C42079CA3477EB (conveyor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_active TINYINT(1) NOT NULL, fullname VARCHAR(64) NOT NULL, phone VARCHAR(15) DEFAULT NULL, address VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user__user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_32745D0A92FC23A8 (username_canonical), UNIQUE INDEX UNIQ_32745D0AA0D96FBF (email_canonical), UNIQUE INDEX UNIQ_32745D0AC05FB297 (confirmation_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_data (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, profile_photo VARCHAR(255) DEFAULT NULL, email VARCHAR(64) DEFAULT NULL, phone VARCHAR(20) DEFAULT NULL, is_active TINYINT(1) NOT NULL, username VARCHAR(64) NOT NULL, address VARCHAR(128) DEFAULT NULL, device_token VARCHAR(255) DEFAULT NULL, uid VARCHAR(128) DEFAULT NULL, language VARCHAR(5) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, matricule VARCHAR(24) NOT NULL, current_lat DOUBLE PRECISION DEFAULT NULL, current_lng DOUBLE PRECISION DEFAULT NULL, device_id VARCHAR(64) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE route ADD CONSTRAINT FK_2C42079545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE route ADD CONSTRAINT FK_2C42079CA3477EB FOREIGN KEY (conveyor_id) REFERENCES user (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('ALTER TABLE route DROP FOREIGN KEY FK_2C42079545317D1');
        $this->addSql('ALTER TABLE route DROP FOREIGN KEY FK_2C42079CA3477EB');
        $this->addSql('DROP TABLE notification');
        $this->addSql('DROP TABLE refresh_token');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE route');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE user__user');
        $this->addSql('DROP TABLE user_data');
        $this->addSql('DROP TABLE vehicle');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
