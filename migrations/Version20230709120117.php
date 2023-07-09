<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230709120117 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY FK_351268BBDAC5BE2B');
        $this->addSql('DROP INDEX IDX_351268BBDAC5BE2B ON abonnement');
        $this->addSql('ALTER TABLE abonnement DROP entreprise_id_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abonnement ADD entreprise_id_id BINARY(16) DEFAULT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BBDAC5BE2B FOREIGN KEY (entreprise_id_id) REFERENCES entreprise (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_351268BBDAC5BE2B ON abonnement (entreprise_id_id)');
    }
}
