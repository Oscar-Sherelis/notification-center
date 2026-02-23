<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260223204415 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // First, delete orphaned records
        $this->addSql('DELETE FROM devices WHERE user_id NOT IN (SELECT id FROM users)');

        // Then add the foreign key
        $this->addSql('ALTER TABLE devices ADD CONSTRAINT FK_11074E9AA76ED395 FOREIGN KEY (user_id) REFERENCES users (id)');
        $this->addSql('CREATE INDEX IDX_11074E9AA76ED395 ON devices (user_id)');
        $this->addSql('ALTER TABLE users CHANGE country_code country_code VARCHAR(2) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs

    }
}
