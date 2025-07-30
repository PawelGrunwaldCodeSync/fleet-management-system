<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Create new table Fleet.
 */
final class Version20250728205237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create new table of Fleet entity';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('
            CREATE TABLE fleet (
                id INT AUTO_INCREMENT NOT NULL,
                name VARCHAR(150) NOT NULL,
                address VARCHAR(255) NOT NULL,
                working_hours VARCHAR(80) DEFAULT NULL,
                created_at DATETIME NOT NULL,
                updated_at DATETIME NOT NULL,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE fleet');
    }
}
