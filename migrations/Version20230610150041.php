<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230610150041 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rapport ADD category_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE rapport ADD CONSTRAINT FK_BE34A09C12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('CREATE INDEX IDX_BE34A09C12469DE2 ON rapport (category_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rapport DROP FOREIGN KEY FK_BE34A09C12469DE2');
        $this->addSql('DROP INDEX IDX_BE34A09C12469DE2 ON rapport');
        $this->addSql('ALTER TABLE rapport DROP category_id');
    }
}
