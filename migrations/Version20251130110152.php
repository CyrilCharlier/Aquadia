<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251130110152 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plante ADD aquarium_id INT NOT NULL');
        $this->addSql('ALTER TABLE plante ADD CONSTRAINT FK_517A69477051F3DE FOREIGN KEY (aquarium_id) REFERENCES aquarium (id)');
        $this->addSql('CREATE INDEX IDX_517A69477051F3DE ON plante (aquarium_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plante DROP FOREIGN KEY FK_517A69477051F3DE');
        $this->addSql('DROP INDEX IDX_517A69477051F3DE ON plante');
        $this->addSql('ALTER TABLE plante DROP aquarium_id');
    }
}
