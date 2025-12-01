<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251129175349 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aquarium ADD type_aquarium VARCHAR(255) NOT NULL');
        // Remplacer "" ou NULL par une valeur par défaut
        $this->addSql("UPDATE aquarium SET type_aquarium = 'eau_douce' WHERE type_aquarium IS NULL OR type_aquarium = ''");
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aquarium DROP type_aquarium');
    }
}
