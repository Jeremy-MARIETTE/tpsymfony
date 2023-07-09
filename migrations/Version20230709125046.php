<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230709125046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abonnement DROP FOREIGN KEY FK_351268BB6BDDA206');
        $this->addSql('DROP INDEX IDX_351268BB6BDDA206 ON abonnement');
        $this->addSql('ALTER TABLE abonnement DROP abo_id');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE abonnement ADD abo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE abonnement ADD CONSTRAINT FK_351268BB6BDDA206 FOREIGN KEY (abo_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_351268BB6BDDA206 ON abonnement (abo_id)');
    }
}
