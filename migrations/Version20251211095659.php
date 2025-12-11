<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251211095659 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE user_ui_preferences (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, color_add_fish VARCHAR(10) DEFAULT NULL, color_add_plant VARCHAR(10) DEFAULT NULL, color_add_invertebrate VARCHAR(10) DEFAULT NULL, color_default VARCHAR(10) DEFAULT NULL, UNIQUE INDEX UNIQ_91CD7964A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_ui_preferences ADD CONSTRAINT FK_91CD7964A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE evenement_categorie ADD CONSTRAINT FK_E723DAE5A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_ui_preferences DROP FOREIGN KEY FK_91CD7964A76ED395');
        $this->addSql('DROP TABLE user_ui_preferences');
        $this->addSql('ALTER TABLE evenement_categorie DROP FOREIGN KEY FK_E723DAE5A76ED395');
    }
}
