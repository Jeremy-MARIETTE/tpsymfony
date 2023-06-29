<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230629183801 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ronde ADD lat_depart LONGTEXT DEFAULT NULL, ADD lnt_depart LONGTEXT DEFAULT NULL, ADD lat_retour LONGTEXT DEFAULT NULL, ADD lnt_retour LONGTEXT DEFAULT NULL, DROP gps');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE ronde ADD gps LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', DROP lat_depart, DROP lnt_depart, DROP lat_retour, DROP lnt_retour');
    }
}
