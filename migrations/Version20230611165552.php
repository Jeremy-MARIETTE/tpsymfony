<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230611165552 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE ronde (id INT AUTO_INCREMENT NOT NULL, site_id INT DEFAULT NULL, debut_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', retour_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', observation LONGTEXT NOT NULL, INDEX IDX_58757EB9F6BD1646 (site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ronde ADD CONSTRAINT FK_58757EB9F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ronde DROP FOREIGN KEY FK_58757EB9F6BD1646');
        $this->addSql('DROP TABLE ronde');
    }
}
