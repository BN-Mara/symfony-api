<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241005141457 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE enterprise (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(100) NOT NULL, address VARCHAR(128) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE line (id INT AUTO_INCREMENT NOT NULL, region_id INT NOT NULL, name VARCHAR(100) NOT NULL, description VARCHAR(128) DEFAULT NULL, payment_type VARCHAR(10) NOT NULL, ticket_price DOUBLE PRECISION DEFAULT NULL, INDEX IDX_D114B4F698260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE name (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE nfc_card_line (nfc_card_id INT NOT NULL, line_id INT NOT NULL, INDEX IDX_6609D6828B9461B0 (nfc_card_id), INDEX IDX_6609D6824D7B7542 (line_id), PRIMARY KEY(nfc_card_id, line_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stop (id INT AUTO_INCREMENT NOT NULL, line_id INT NOT NULL, name VARCHAR(100) NOT NULL, lat DOUBLE PRECISION NOT NULL, lng DOUBLE PRECISION NOT NULL, created_by VARCHAR(100) DEFAULT NULL, created_at DATETIME DEFAULT NULL, INDEX IDX_B95616B64D7B7542 (line_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE subscription_plan (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(100) NOT NULL, description VARCHAR(128) DEFAULT NULL, amount DOUBLE PRECISION NOT NULL, duration INT NOT NULL, created_by VARCHAR(100) DEFAULT NULL, created_at DATETIME DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acl_classes (id INT UNSIGNED AUTO_INCREMENT NOT NULL, class_type VARCHAR(200) NOT NULL, UNIQUE INDEX UNIQ_69DD750638A36066 (class_type), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acl_security_identities (id INT UNSIGNED AUTO_INCREMENT NOT NULL, identifier VARCHAR(200) NOT NULL, username TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_8835EE78772E836AF85E0677 (identifier, username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acl_object_identities (id INT UNSIGNED AUTO_INCREMENT NOT NULL, parent_object_identity_id INT UNSIGNED DEFAULT NULL, class_id INT UNSIGNED NOT NULL, object_identifier VARCHAR(100) NOT NULL, entries_inheriting TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_9407E5494B12AD6EA000B10 (object_identifier, class_id), INDEX IDX_9407E54977FA751A (parent_object_identity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acl_object_identity_ancestors (object_identity_id INT UNSIGNED NOT NULL, ancestor_id INT UNSIGNED NOT NULL, INDEX IDX_825DE2993D9AB4A6 (object_identity_id), INDEX IDX_825DE299C671CEA1 (ancestor_id), PRIMARY KEY(object_identity_id, ancestor_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE acl_entries (id INT UNSIGNED AUTO_INCREMENT NOT NULL, class_id INT UNSIGNED NOT NULL, object_identity_id INT UNSIGNED DEFAULT NULL, security_identity_id INT UNSIGNED NOT NULL, field_name VARCHAR(50) DEFAULT NULL, ace_order SMALLINT UNSIGNED NOT NULL, mask INT NOT NULL, granting TINYINT(1) NOT NULL, granting_strategy VARCHAR(30) NOT NULL, audit_success TINYINT(1) NOT NULL, audit_failure TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_46C8B806EA000B103D9AB4A64DEF17BCE4289BF4 (class_id, object_identity_id, field_name, ace_order), INDEX IDX_46C8B806EA000B103D9AB4A6DF9183C9 (class_id, object_identity_id, security_identity_id), INDEX IDX_46C8B806EA000B10 (class_id), INDEX IDX_46C8B8063D9AB4A6 (object_identity_id), INDEX IDX_46C8B806DF9183C9 (security_identity_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE line ADD CONSTRAINT FK_D114B4F698260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('ALTER TABLE nfc_card_line ADD CONSTRAINT FK_6609D6828B9461B0 FOREIGN KEY (nfc_card_id) REFERENCES nfc_card (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nfc_card_line ADD CONSTRAINT FK_6609D6824D7B7542 FOREIGN KEY (line_id) REFERENCES line (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE stop ADD CONSTRAINT FK_B95616B64D7B7542 FOREIGN KEY (line_id) REFERENCES line (id)');
        $this->addSql('ALTER TABLE acl_object_identities ADD CONSTRAINT FK_9407E54977FA751A FOREIGN KEY (parent_object_identity_id) REFERENCES acl_object_identities (id)');
        $this->addSql('ALTER TABLE acl_object_identity_ancestors ADD CONSTRAINT FK_825DE2993D9AB4A6 FOREIGN KEY (object_identity_id) REFERENCES acl_object_identities (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE acl_object_identity_ancestors ADD CONSTRAINT FK_825DE299C671CEA1 FOREIGN KEY (ancestor_id) REFERENCES acl_object_identities (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE acl_entries ADD CONSTRAINT FK_46C8B806EA000B10 FOREIGN KEY (class_id) REFERENCES acl_classes (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE acl_entries ADD CONSTRAINT FK_46C8B8063D9AB4A6 FOREIGN KEY (object_identity_id) REFERENCES acl_object_identities (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE acl_entries ADD CONSTRAINT FK_46C8B806DF9183C9 FOREIGN KEY (security_identity_id) REFERENCES acl_security_identities (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE nfc_card ADD subscription_from_date DATETIME DEFAULT NULL, ADD subscription_end_date DATETIME DEFAULT NULL, ADD code VARCHAR(6) NOT NULL');
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY FK_741D53CD98260155');
        $this->addSql('DROP INDEX IDX_741D53CD98260155 ON place');
        $this->addSql('ALTER TABLE place ADD line_id INT NOT NULL, DROP region_id');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CD4D7B7542 FOREIGN KEY (line_id) REFERENCES line (id)');
        $this->addSql('CREATE INDEX IDX_741D53CD4D7B7542 ON place (line_id)');
        $this->addSql('ALTER TABLE recharge_carte ADD recharge_type VARCHAR(10) NOT NULL, ADD from_date DATETIME DEFAULT NULL, ADD to_date DATETIME DEFAULT NULL, ADD old_from_date DATETIME DEFAULT NULL, ADD old_to_date DATETIME DEFAULT NULL, ADD subscription_id INT DEFAULT NULL, ADD reference VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE recharge_user ADD reference VARCHAR(10) NOT NULL');
        $this->addSql('ALTER TABLE route ADD line_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE route ADD CONSTRAINT FK_2C420794D7B7542 FOREIGN KEY (line_id) REFERENCES line (id)');
        $this->addSql('CREATE INDEX IDX_2C420794D7B7542 ON route (line_id)');
        $this->addSql('ALTER TABLE transaction ADD old_from_date DATETIME DEFAULT NULL, ADD old_to_date DATETIME DEFAULT NULL, ADD reference VARCHAR(10) NOT NULL, ADD payment_type VARCHAR(10) NOT NULL, ADD latitude DOUBLE PRECISION DEFAULT NULL, ADD longitude DOUBLE PRECISION DEFAULT NULL, CHANGE route_id route_id INT NOT NULL');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E48698260155');
        $this->addSql('DROP INDEX IDX_1B80E48698260155 ON vehicle');
        $this->addSql('ALTER TABLE vehicle ADD line_id INT NOT NULL, DROP region_id');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E4864D7B7542 FOREIGN KEY (line_id) REFERENCES line (id)');
        $this->addSql('CREATE INDEX IDX_1B80E4864D7B7542 ON vehicle (line_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE place DROP FOREIGN KEY FK_741D53CD4D7B7542');
        $this->addSql('ALTER TABLE route DROP FOREIGN KEY FK_2C420794D7B7542');
        $this->addSql('ALTER TABLE vehicle DROP FOREIGN KEY FK_1B80E4864D7B7542');
        $this->addSql('ALTER TABLE line DROP FOREIGN KEY FK_D114B4F698260155');
        $this->addSql('ALTER TABLE nfc_card_line DROP FOREIGN KEY FK_6609D6828B9461B0');
        $this->addSql('ALTER TABLE nfc_card_line DROP FOREIGN KEY FK_6609D6824D7B7542');
        $this->addSql('ALTER TABLE stop DROP FOREIGN KEY FK_B95616B64D7B7542');
        $this->addSql('ALTER TABLE acl_object_identities DROP FOREIGN KEY FK_9407E54977FA751A');
        $this->addSql('ALTER TABLE acl_object_identity_ancestors DROP FOREIGN KEY FK_825DE2993D9AB4A6');
        $this->addSql('ALTER TABLE acl_object_identity_ancestors DROP FOREIGN KEY FK_825DE299C671CEA1');
        $this->addSql('ALTER TABLE acl_entries DROP FOREIGN KEY FK_46C8B806EA000B10');
        $this->addSql('ALTER TABLE acl_entries DROP FOREIGN KEY FK_46C8B8063D9AB4A6');
        $this->addSql('ALTER TABLE acl_entries DROP FOREIGN KEY FK_46C8B806DF9183C9');
        $this->addSql('DROP TABLE enterprise');
        $this->addSql('DROP TABLE line');
        $this->addSql('DROP TABLE name');
        $this->addSql('DROP TABLE nfc_card_line');
        $this->addSql('DROP TABLE stop');
        $this->addSql('DROP TABLE subscription_plan');
        $this->addSql('DROP TABLE acl_classes');
        $this->addSql('DROP TABLE acl_security_identities');
        $this->addSql('DROP TABLE acl_object_identities');
        $this->addSql('DROP TABLE acl_object_identity_ancestors');
        $this->addSql('DROP TABLE acl_entries');
        $this->addSql('ALTER TABLE nfc_card DROP subscription_from_date, DROP subscription_end_date, DROP code');
        $this->addSql('DROP INDEX IDX_741D53CD4D7B7542 ON place');
        $this->addSql('ALTER TABLE place ADD region_id INT DEFAULT NULL, DROP line_id');
        $this->addSql('ALTER TABLE place ADD CONSTRAINT FK_741D53CD98260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('CREATE INDEX IDX_741D53CD98260155 ON place (region_id)');
        $this->addSql('ALTER TABLE recharge_carte DROP recharge_type, DROP from_date, DROP to_date, DROP old_from_date, DROP old_to_date, DROP subscription_id, DROP reference');
        $this->addSql('ALTER TABLE recharge_user DROP reference');
        $this->addSql('DROP INDEX IDX_2C420794D7B7542 ON route');
        $this->addSql('ALTER TABLE route DROP line_id');
        $this->addSql('ALTER TABLE transaction DROP old_from_date, DROP old_to_date, DROP reference, DROP payment_type, DROP latitude, DROP longitude, CHANGE route_id route_id INT DEFAULT NULL');
        $this->addSql('DROP INDEX IDX_1B80E4864D7B7542 ON vehicle');
        $this->addSql('ALTER TABLE vehicle ADD region_id INT DEFAULT NULL, DROP line_id');
        $this->addSql('ALTER TABLE vehicle ADD CONSTRAINT FK_1B80E48698260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('CREATE INDEX IDX_1B80E48698260155 ON vehicle (region_id)');
    }
}
