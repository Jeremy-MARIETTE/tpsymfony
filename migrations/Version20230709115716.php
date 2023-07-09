<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230709115716 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY FK_351268BBA4AEAFEA');
        $this->addSql('DROP INDEX IDX_351268BBA4AEAFEA ON abonnement');
        $this->addSql('ALTER TABLE abonnement DROP entreprise_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abonnement ADD entreprise_id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BBA4AEAFEA FOREIGN KEY (entreprise_id) REFERENCES entreprise (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_351268BBA4AEAFEA ON abonnement (entreprise_id)');
    }
}
