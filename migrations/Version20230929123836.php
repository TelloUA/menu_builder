<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230929123836 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE section_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE section (id INT NOT NULL, restaurant_id INT NOT NULL, name VARCHAR(255) NOT NULL, is_active BOOLEAN NOT NULL, is_temporary BOOLEAN NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2D737AEFB1E7706E ON section (restaurant_id)');
        $this->addSql('ALTER TABLE section ADD CONSTRAINT FK_2D737AEFB1E7706E FOREIGN KEY (restaurant_id) REFERENCES restaurant (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE section_id_seq CASCADE');
        $this->addSql('ALTER TABLE section DROP CONSTRAINT FK_2D737AEFB1E7706E');
        $this->addSql('DROP TABLE section');
    }
}
