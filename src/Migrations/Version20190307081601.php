<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190307081601 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE puppys ADD posted_at DATETIME NOT NULL, ADD title VARCHAR(255) NOT NULL, CHANGE carrousel_id carrousel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE paragraph CHANGE page_id page_id INT DEFAULT NULL, CHANGE body body VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE dogs CHANGE carrousel_id carrousel_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT NULL, CHANGE breed breed VARCHAR(255) DEFAULT NULL, CHANGE lof lof INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images CHANGE carrousel_id carrousel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE dogs CHANGE carrousel_id carrousel_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE breed breed VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci, CHANGE lof lof INT DEFAULT NULL');
        $this->addSql('ALTER TABLE images CHANGE carrousel_id carrousel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE paragraph CHANGE page_id page_id INT DEFAULT NULL, CHANGE body body VARCHAR(255) DEFAULT \'NULL\' COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE puppys DROP posted_at, DROP title, CHANGE carrousel_id carrousel_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
