<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251126075738 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aquarium ADD ph_min DOUBLE PRECISION DEFAULT NULL, ADD ph_max DOUBLE PRECISION DEFAULT NULL, ADD gh_min DOUBLE PRECISION DEFAULT NULL, ADD gh_max DOUBLE PRECISION DEFAULT NULL, ADD kh_min DOUBLE PRECISION DEFAULT NULL, ADD kh_max DOUBLE PRECISION DEFAULT NULL, ADD no2 DOUBLE PRECISION DEFAULT NULL, ADD no3 DOUBLE PRECISION DEFAULT NULL, ADD nhx DOUBLE PRECISION DEFAULT NULL, ADD conductivite DOUBLE PRECISION DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE aquarium DROP ph_min, DROP ph_max, DROP gh_min, DROP gh_max, DROP kh_min, DROP kh_max, DROP no2, DROP no3, DROP nhx, DROP conductivite');
    }
}
