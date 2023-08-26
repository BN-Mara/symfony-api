<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230826083121 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE route (id INT AUTO_INCREMENT NOT NULL, conveyor_id_id INT DEFAULT NULL, vehicle_id INT NOT NULL, destination VARCHAR(128) NOT NULL, ticket_price DOUBLE PRECISION DEFAULT NULL, start_lat DOUBLE PRECISION DEFAULT NULL, start_lng DOUBLE PRECISION DEFAULT NULL, end_lat DOUBLE PRECISION DEFAULT NULL, end_lng DOUBLE PRECISION DEFAULT NULL, passengers INT DEFAULT NULL, origine VARCHAR(128) NOT NULL, starting_time DATETIME DEFAULT NULL, ending_time DATETIME DEFAULT NULL, gpx LONGTEXT DEFAULT NULL, is_active TINYINT(1) DEFAULT NULL, INDEX IDX_2C42079823CE13F (conveyor_id_id), INDEX IDX_2C42079545317D1 (vehicle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicle (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(64) NOT NULL, matricule VARCHAR(24) NOT NULL, current_lat DOUBLE PRECISION DEFAULT NULL, current_lng DOUBLE PRECISION DEFAULT NULL, device_id VARCHAR(64) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE route ADD CONSTRAINT FK_2C42079823CE13F FOREIGN KEY (conveyor_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE route ADD CONSTRAINT FK_2C42079545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('ALTER TABLE user ADD is_active TINYINT(1) NOT NULL, ADD fullname VARCHAR(64) NOT NULL, ADD phone VARCHAR(15) DEFAULT NULL, ADD address VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE route DROP FOREIGN KEY FK_2C42079823CE13F');
        $this->addSql('ALTER TABLE route DROP FOREIGN KEY FK_2C42079545317D1');
        $this->addSql('DROP TABLE route');
        $this->addSql('DROP TABLE vehicle');
        $this->addSql('ALTER TABLE user DROP is_active, DROP fullname, DROP phone, DROP address');
    }
}
