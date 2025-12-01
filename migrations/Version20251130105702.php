<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251130105702 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE espece_plante (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, enable TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE plante (id INT AUTO_INCREMENT NOT NULL, espece_id INT NOT NULL, name VARCHAR(255) NOT NULL, date_ajout DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', comment LONGTEXT NOT NULL, INDEX IDX_517A69472D191E7A (espece_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE plante ADD CONSTRAINT FK_517A69472D191E7A FOREIGN KEY (espece_id) REFERENCES espece_plante (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE plante DROP FOREIGN KEY FK_517A69472D191E7A');
        $this->addSql('DROP TABLE espece_plante');
        $this->addSql('DROP TABLE plante');
    }
}
