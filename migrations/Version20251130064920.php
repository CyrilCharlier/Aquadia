<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251130064920 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE poisson ADD espece_id INT NOT NULL');
        $this->addSql('ALTER TABLE poisson ADD CONSTRAINT FK_7BD645AA2D191E7A FOREIGN KEY (espece_id) REFERENCES espece_poisson (id)');
        $this->addSql('CREATE INDEX IDX_7BD645AA2D191E7A ON poisson (espece_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE poisson DROP FOREIGN KEY FK_7BD645AA2D191E7A');
        $this->addSql('DROP INDEX IDX_7BD645AA2D191E7A ON poisson');
        $this->addSql('ALTER TABLE poisson DROP espece_id');
    }
}
