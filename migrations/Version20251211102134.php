<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251211102134 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_ui_preferences CHANGE color_add_fish color_add_fish VARCHAR(10) DEFAULT \'#2196F3\', CHANGE color_add_plant color_add_plant VARCHAR(10) DEFAULT \'#4CAF50\', CHANGE color_add_invertebrate color_add_invertebrate VARCHAR(10) DEFAULT \'#AB47BC\', CHANGE color_default color_default VARCHAR(10) DEFAULT \'#BDBDBD\', CHANGE color_event_test color_event_test VARCHAR(10) DEFAULT \'#FFC107\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_ui_preferences CHANGE color_add_fish color_add_fish VARCHAR(10) DEFAULT NULL, CHANGE color_add_plant color_add_plant VARCHAR(10) DEFAULT NULL, CHANGE color_add_invertebrate color_add_invertebrate VARCHAR(10) DEFAULT NULL, CHANGE color_default color_default VARCHAR(10) DEFAULT NULL, CHANGE color_event_test color_event_test VARCHAR(10) DEFAULT NULL');
    }
}
