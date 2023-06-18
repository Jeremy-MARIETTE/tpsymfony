<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230618095743 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE consignes ADD token VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE poste ADD token VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE rapport ADD token VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE ronde ADD token VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ronde DROP token');
        $this->addSql('ALTER TABLE consignes DROP token');
        $this->addSql('ALTER TABLE poste DROP token');
        $this->addSql('ALTER TABLE rapport DROP token');
    }
}
