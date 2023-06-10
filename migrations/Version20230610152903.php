<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230610152903 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE site_user (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site_user_site (site_user_id INT NOT NULL, site_id INT NOT NULL, INDEX IDX_75C833585CCA315E (site_user_id), INDEX IDX_75C83358F6BD1646 (site_id), PRIMARY KEY(site_user_id, site_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site_user_user (site_user_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_9118ECF55CCA315E (site_user_id), INDEX IDX_9118ECF5A76ED395 (user_id), PRIMARY KEY(site_user_id, user_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE site_user_site ADD CONSTRAINT FK_75C833585CCA315E FOREIGN KEY (site_user_id) REFERENCES site_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE site_user_site ADD CONSTRAINT FK_75C83358F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE site_user_user ADD CONSTRAINT FK_9118ECF55CCA315E FOREIGN KEY (site_user_id) REFERENCES site_user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE site_user_user ADD CONSTRAINT FK_9118ECF5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE site_user_site DROP FOREIGN KEY FK_75C833585CCA315E');
        $this->addSql('ALTER TABLE site_user_site DROP FOREIGN KEY FK_75C83358F6BD1646');
        $this->addSql('ALTER TABLE site_user_user DROP FOREIGN KEY FK_9118ECF55CCA315E');
        $this->addSql('ALTER TABLE site_user_user DROP FOREIGN KEY FK_9118ECF5A76ED395');
        $this->addSql('DROP TABLE site_user');
        $this->addSql('DROP TABLE site_user_site');
        $this->addSql('DROP TABLE site_user_user');
    }
}
