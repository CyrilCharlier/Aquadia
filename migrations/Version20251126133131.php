<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251126133131 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE test (id INT AUTO_INCREMENT NOT NULL, aquarium_id INT NOT NULL, ph DOUBLE PRECISION DEFAULT NULL, gh DOUBLE PRECISION DEFAULT NULL, kh DOUBLE PRECISION DEFAULT NULL, no2 DOUBLE PRECISION DEFAULT NULL, no3 DOUBLE PRECISION DEFAULT NULL, nhx DOUBLE PRECISION DEFAULT NULL, conductivite DOUBLE PRECISION DEFAULT NULL, INDEX IDX_D87F7E0C7051F3DE (aquarium_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE test ADD CONSTRAINT FK_D87F7E0C7051F3DE FOREIGN KEY (aquarium_id) REFERENCES aquarium (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE test DROP FOREIGN KEY FK_D87F7E0C7051F3DE');
        $this->addSql('DROP TABLE test');
    }
}
