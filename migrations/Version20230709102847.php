<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230709102847 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prise_de_service ADD site_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE prise_de_service ADD CONSTRAINT FK_DD0A058FF6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('CREATE INDEX IDX_DD0A058FF6BD1646 ON prise_de_service (site_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE prise_de_service DROP FOREIGN KEY FK_DD0A058FF6BD1646');
        $this->addSql('DROP INDEX IDX_DD0A058FF6BD1646 ON prise_de_service');
        $this->addSql('ALTER TABLE prise_de_service DROP site_id');
    }
}
