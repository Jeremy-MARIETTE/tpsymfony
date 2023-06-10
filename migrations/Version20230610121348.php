<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230610121348 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rapport (id INT AUTO_INCREMENT NOT NULL, auteur VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site (id INT AUTO_INCREMENT NOT NULL, rapport_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, cp VARCHAR(255) NOT NULL, INDEX IDX_694309E41DFBCC46 (rapport_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site_user (site_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_B6096BB0F6BD1646 (site_id), INDEX IDX_B6096BB0A76ED395 (user_id), PRIMARY KEY(site_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE site ADD CONSTRAINT FK_694309E41DFBCC46 FOREIGN KEY (rapport_id) REFERENCES rapport (id)');
        $this->addSql('ALTER TABLE site_user ADD CONSTRAINT FK_B6096BB0F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE site_user ADD CONSTRAINT FK_B6096BB0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE site DROP FOREIGN KEY FK_694309E41DFBCC46');
        $this->addSql('ALTER TABLE site_user DROP FOREIGN KEY FK_B6096BB0F6BD1646');
        $this->addSql('ALTER TABLE site_user DROP FOREIGN KEY FK_B6096BB0A76ED395');
        $this->addSql('DROP TABLE rapport');
        $this->addSql('DROP TABLE site');
        $this->addSql('DROP TABLE site_user');
    }
}
