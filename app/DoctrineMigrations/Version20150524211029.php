<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20150524211029 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        //$this->addSql('CREATE TABLE ext_translations (id INT AUTO_INCREMENT NOT NULL, locale VARCHAR(8) NOT NULL, object_class VARCHAR(255) NOT NULL, field VARCHAR(32) NOT NULL, foreign_key VARCHAR(64) NOT NULL, content LONGTEXT DEFAULT NULL, INDEX translations_lookup_idx (locale, object_class, foreign_key), UNIQUE INDEX lookup_unique_idx (locale, object_class, field, foreign_key), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        //$this->addSql('CREATE TABLE ext_log_entries (id INT AUTO_INCREMENT NOT NULL, action VARCHAR(8) NOT NULL, logged_at DATETIME NOT NULL, object_id VARCHAR(64) DEFAULT NULL, object_class VARCHAR(255) NOT NULL, version INT NOT NULL, data LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', username VARCHAR(255) DEFAULT NULL, INDEX log_class_lookup_idx (object_class), INDEX log_date_lookup_idx (logged_at), INDEX log_user_lookup_idx (username), INDEX log_version_lookup_idx (object_id, object_class, version), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        //$this->addSql('CREATE TABLE elfinder_file (id INT AUTO_INCREMENT NOT NULL, parent_id INT NOT NULL, name VARCHAR(255) NOT NULL, content LONGBLOB NOT NULL, size INT NOT NULL, mtime INT NOT NULL, mime VARCHAR(255) NOT NULL, `read` VARCHAR(255) NOT NULL, `write` VARCHAR(255) NOT NULL, locked VARCHAR(255) NOT NULL, hidden VARCHAR(255) NOT NULL, width INT NOT NULL, height INT NOT NULL, INDEX parent_id (parent_id), UNIQUE INDEX parent_name (parent_id, name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bd_category (id INT AUTO_INCREMENT NOT NULL, parent_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, bundle VARCHAR(255) NOT NULL, status TINYINT(1) NOT NULL, owner_id INT NOT NULL, created_on DATE NOT NULL, lft INT NOT NULL, rgt INT NOT NULL, root INT DEFAULT NULL, lvl INT NOT NULL, INDEX IDX_75B67210727ACA70 (parent_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bd_category ADD CONSTRAINT FK_75B67210727ACA70 FOREIGN KEY (parent_id) REFERENCES bd_category (id) ON DELETE CASCADE');
        //$this->addSql('DROP TABLE sessions');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        /*$this->addSql('ALTER TABLE bd_category DROP FOREIGN KEY FK_75B67210727ACA70');
        $this->addSql('CREATE TABLE sessions (sess_id TINYBLOB NOT NULL, sess_data LONGBLOB NOT NULL, sess_time INT UNSIGNED NOT NULL, sess_lifetime INT NOT NULL, PRIMARY KEY(sess_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE ext_translations');
        $this->addSql('DROP TABLE ext_log_entries');
        $this->addSql('DROP TABLE elfinder_file');
        $this->addSql('DROP TABLE bd_category');*/
    }
}
