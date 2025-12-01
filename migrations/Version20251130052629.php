<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251130052629 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE poisson ADD aquarium_id INT NOT NULL');
        $this->addSql('ALTER TABLE poisson ADD CONSTRAINT FK_7BD645AA7051F3DE FOREIGN KEY (aquarium_id) REFERENCES aquarium (id)');
        $this->addSql('CREATE INDEX IDX_7BD645AA7051F3DE ON poisson (aquarium_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE poisson DROP FOREIGN KEY FK_7BD645AA7051F3DE');
        $this->addSql('DROP INDEX IDX_7BD645AA7051F3DE ON poisson');
        $this->addSql('ALTER TABLE poisson DROP aquarium_id');
    }
}
