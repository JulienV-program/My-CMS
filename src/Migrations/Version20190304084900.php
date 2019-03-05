<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190304084900 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE puppys (id INT AUTO_INCREMENT NOT NULL, carrousel_id INT DEFAULT NULL, description VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_83EDE9281AA511C9 (carrousel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE carrousel (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE paragraph (id INT AUTO_INCREMENT NOT NULL, page_id INT DEFAULT NULL, title VARCHAR(127) NOT NULL, body VARCHAR(255) DEFAULT NULL, INDEX IDX_7DD39862C4663E4 (page_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dogs (id INT AUTO_INCREMENT NOT NULL, carrousel_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) DEFAULT NULL, breed VARCHAR(255) DEFAULT NULL, lof INT DEFAULT NULL, UNIQUE INDEX UNIQ_353BEEB31AA511C9 (carrousel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page (id INT AUTO_INCREMENT NOT NULL, page_name VARCHAR(64) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE page_carrousel (page_id INT NOT NULL, carrousel_id INT NOT NULL, INDEX IDX_D4EF0F47C4663E4 (page_id), INDEX IDX_D4EF0F471AA511C9 (carrousel_id), PRIMARY KEY(page_id, carrousel_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE images (id INT AUTO_INCREMENT NOT NULL, carrousel_id INT DEFAULT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_E01FBE6A1AA511C9 (carrousel_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE puppys ADD CONSTRAINT FK_83EDE9281AA511C9 FOREIGN KEY (carrousel_id) REFERENCES carrousel (id)');
        $this->addSql('ALTER TABLE paragraph ADD CONSTRAINT FK_7DD39862C4663E4 FOREIGN KEY (page_id) REFERENCES page (id)');
        $this->addSql('ALTER TABLE dogs ADD CONSTRAINT FK_353BEEB31AA511C9 FOREIGN KEY (carrousel_id) REFERENCES carrousel (id)');
        $this->addSql('ALTER TABLE page_carrousel ADD CONSTRAINT FK_D4EF0F47C4663E4 FOREIGN KEY (page_id) REFERENCES page (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE page_carrousel ADD CONSTRAINT FK_D4EF0F471AA511C9 FOREIGN KEY (carrousel_id) REFERENCES carrousel (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE images ADD CONSTRAINT FK_E01FBE6A1AA511C9 FOREIGN KEY (carrousel_id) REFERENCES carrousel (id)');
        $this->addSql('ALTER TABLE user CHANGE roles roles JSON NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE puppys DROP FOREIGN KEY FK_83EDE9281AA511C9');
        $this->addSql('ALTER TABLE dogs DROP FOREIGN KEY FK_353BEEB31AA511C9');
        $this->addSql('ALTER TABLE page_carrousel DROP FOREIGN KEY FK_D4EF0F471AA511C9');
        $this->addSql('ALTER TABLE images DROP FOREIGN KEY FK_E01FBE6A1AA511C9');
        $this->addSql('ALTER TABLE paragraph DROP FOREIGN KEY FK_7DD39862C4663E4');
        $this->addSql('ALTER TABLE page_carrousel DROP FOREIGN KEY FK_D4EF0F47C4663E4');
        $this->addSql('DROP TABLE puppys');
        $this->addSql('DROP TABLE carrousel');
        $this->addSql('DROP TABLE paragraph');
        $this->addSql('DROP TABLE dogs');
        $this->addSql('DROP TABLE page');
        $this->addSql('DROP TABLE page_carrousel');
        $this->addSql('DROP TABLE images');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COLLATE utf8mb4_bin');
    }
}
