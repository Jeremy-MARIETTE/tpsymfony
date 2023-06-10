<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230610150501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE site_user DROP FOREIGN KEY FK_B6096BB0A76ED395');
        $this->addSql('ALTER TABLE site_user DROP FOREIGN KEY FK_B6096BB0F6BD1646');
        $this->addSql('DROP TABLE site_user');
        $this->addSql('ALTER TABLE site DROP FOREIGN KEY FK_694309E41DFBCC46');
        $this->addSql('DROP INDEX IDX_694309E41DFBCC46 ON site');
        $this->addSql('ALTER TABLE site DROP rapport_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE site_user (site_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_B6096BB0F6BD1646 (site_id), INDEX IDX_B6096BB0A76ED395 (user_id), PRIMARY KEY(site_id, user_id)) DEFAULT CHARACTER SET utf8mb3 COLLATE `utf8mb3_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE site_user ADD CONSTRAINT FK_B6096BB0A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE site_user ADD CONSTRAINT FK_B6096BB0F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE site ADD rapport_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE site ADD CONSTRAINT FK_694309E41DFBCC46 FOREIGN KEY (rapport_id) REFERENCES rapport (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_694309E41DFBCC46 ON site (rapport_id)');
    }
}
